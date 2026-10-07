#Requires -Version 5.1
# Builds the static site in dist/ from the local WordPress, and optionally deploys it to Netlify.
#
#   .\scripts\publish.ps1            # export only; preview with: php -S 127.0.0.1:8099 -t dist
#   .\scripts\publish.ps1 -Deploy    # export, then deploy to Netlify (production)
#
# First deploy only: run `npx netlify-cli login`, then `npx netlify-cli link` (or `sites:create`)
# in this folder, and turn on Forms → "Enable form detection" in the Netlify site settings.
param([switch]$Deploy)

# Not 'Stop': in PowerShell 5.1 that turns native stderr output into errors.
$ErrorActionPreference = 'Continue'
Set-Location (Split-Path $PSScriptRoot -Parent)

$cfg = @{}
foreach ($line in Get-Content .env) {
    if ($line -match '^([A-Z_]+)=(.*)$') { $cfg[$Matches[1]] = $Matches[2].Trim() }
}

docker compose up -d
if ($LASTEXITCODE -ne 0) { throw 'docker compose up failed. Is Docker Desktop running?' }

$exportArgs = @('scripts/export-static.php', "--source=$($cfg.WP_URL)")
if ($cfg.STATIC_URL) {
    $exportArgs += "--url=$($cfg.STATIC_URL)"
} else {
    Write-Host 'STATIC_URL is not set in .env: links will be root-relative and canonical/og:url tags relative.'
}
php @exportArgs
if ($LASTEXITCODE -ne 0) { throw 'Static export failed; nothing was deployed.' }

Copy-Item static\* dist\ -Recurse -Force

if ($Deploy) {
    npx --yes netlify-cli deploy --prod --dir=dist
    if ($LASTEXITCODE -ne 0) { throw 'Netlify deploy failed.' }
}
