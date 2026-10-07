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
    Invoke-WP option update blogdescription 'IT professional and developer'
    Invoke-WP plugin delete hello akismet
}

Invoke-WP theme activate jmc-portfolio
Invoke-WP plugin activate jmc-portfolio-core
Invoke-WP rewrite structure '/%postname%/'

$projectCount = docker compose run --rm cli wp post list --post_type=project --post_status=any --format=count
if ([int]$projectCount -eq 0) {
    Write-Host 'Seeding sample projects...'
    $samples = @(
        @{ Title = 'Warehouse Dashboard'; Excerpt = 'Live inventory and dock metrics for a multi-site warehouse operation.'; Skills = 'SQL Server,Power BI' },
        @{ Title = 'Network Refresh'; Excerpt = 'Planned and rolled out a zero-downtime network upgrade across three offices.'; Skills = 'Networking,Infrastructure' },
        @{ Title = 'Internal Tools Portal'; Excerpt = 'A single sign-on portal that replaced a dozen spreadsheets and shared drives.'; Skills = 'PHP,WordPress' }
    )
    foreach ($s in $samples) {
        $id = docker compose run --rm cli wp post create --post_type=project --post_status=publish `
            "--post_title=$($s.Title)" "--post_excerpt=$($s.Excerpt)" `
            '--post_content=<!-- wp:paragraph --><p>Replace this with the story of the project: the problem, what you did, and the result.</p><!-- /wp:paragraph -->' `
            --porcelain
        if ($LASTEXITCODE -ne 0) { throw "Could not create sample project '$($s.Title)'" }
        $id = "$id".Trim()
        Invoke-WP post term set $id project_skill @($s.Skills -split ',')
        Invoke-WP post meta update $id project_url 'https://example.com'
    }
}

Write-Host ''
Write-Host "Site:  $($cfg.WP_URL)"
Write-Host "Admin: $($cfg.WP_URL)/wp-admin  (user: $($cfg.WP_ADMIN_USER), password in .env)"
