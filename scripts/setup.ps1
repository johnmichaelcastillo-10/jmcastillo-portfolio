#Requires -Version 5.1
# One-time local setup: creates .env, starts the containers, installs WordPress,
# activates the portfolio theme and plugin, and seeds sample projects.
# Safe to re-run; steps that are already done are skipped.
# Not 'Stop': in PowerShell 5.1 that turns docker's progress output on stderr into
# errors. Native commands are checked with $LASTEXITCODE instead.
$ErrorActionPreference = 'Continue'
Set-Location (Split-Path $PSScriptRoot -Parent)

function New-Secret([int]$Length = 24) {
    $chars = [char[]]'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789'
    $bytes = New-Object byte[] $Length
    [Security.Cryptography.RandomNumberGenerator]::Create().GetBytes($bytes)
    -join ($bytes | ForEach-Object { $chars[$_ % $chars.Length] })
}

function Invoke-WP {
    docker compose run --rm cli wp @args
    if ($LASTEXITCODE -ne 0) { throw "wp $($args -join ' ') failed" }
}

if (-not (Test-Path .env)) {
    $content = Get-Content .env.example -Raw
    foreach ($key in 'WP_ADMIN_PASSWORD', 'DB_PASSWORD', 'DB_ROOT_PASSWORD') {
        $content = $content -replace "(?m)^$key=[^\r\n]*", "$key=$(New-Secret)"
    }
    # Write without a BOM; docker compose rejects a BOM in .env.
    [IO.File]::WriteAllText((Join-Path $PWD '.env'), $content)
    Write-Host 'Created .env with random passwords.'
}

$cfg = @{}
foreach ($line in Get-Content .env) {
    if ($line -match '^([A-Z_]+)=(.*)$') { $cfg[$Matches[1]] = $Matches[2].Trim() }
}

docker compose up -d
if ($LASTEXITCODE -ne 0) { throw 'docker compose up failed. Is Docker Desktop running?' }

Write-Host 'Waiting for WordPress to finish its first start...'
$ready = $false
for ($i = 0; $i -lt 60; $i++) {
    docker compose exec -T wordpress test -f /var/www/html/wp-config.php
    if ($LASTEXITCODE -eq 0) { $ready = $true; break }
    Start-Sleep -Seconds 2
}
if (-not $ready) { throw 'WordPress did not create wp-config.php in time. Check: docker compose logs wordpress' }

docker compose run --rm cli wp core is-installed
if ($LASTEXITCODE -ne 0) {
    Invoke-WP core install "--url=$($cfg.WP_URL)" "--title=$($cfg.WP_TITLE)" `
        "--admin_user=$($cfg.WP_ADMIN_USER)" "--admin_password=$($cfg.WP_ADMIN_PASSWORD)" `
        "--admin_email=$($cfg.WP_ADMIN_EMAIL)" --skip-email
    Invoke-WP plugin delete hello akismet
}

Invoke-WP theme activate jmc-portfolio
Invoke-WP plugin activate jmc-portfolio-core
Invoke-WP rewrite structure '/%postname%/'

$projectCount = docker compose run --rm cli wp post list --post_type=project --post_status=any --format=count
if ([int]$projectCount -eq 0) {
    Write-Host 'Adding portfolio content...'
    Invoke-WP eval-file /scripts/seed-content.php
}

# Only fills in projects that have no featured image yet, so it's safe on every run.
Invoke-WP eval-file /scripts/seed-images.php

Write-Host ''
Write-Host "Site:  $($cfg.WP_URL)"
Write-Host "Admin: $($cfg.WP_URL)/wp-admin  (user: $($cfg.WP_ADMIN_USER), password in .env)"
