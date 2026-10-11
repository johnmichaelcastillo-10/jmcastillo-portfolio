#Requires -Version 5.1
# Builds the static site in dist/ from the local WordPress, and optionally deploys it to Vercel.
#
#   .\scripts\publish.ps1            # export only; preview with: php -S 127.0.0.1:8099 -t dist
#   .\scripts\publish.ps1 -Deploy    # export, then deploy to Vercel (production)
#
# First deploy only: `npm install -g vercel`, `vercel login`, then `vercel link` in this folder
# (creates .vercel/, which is copied into dist/ so the deploy lands on the same project).
# .env needs STATIC_URL (the Vercel domain) and WEB3FORMS_KEY (the contact form's access key).
param([switch]$Deploy)

# Not 'Stop': in PowerShell 5.1 that turns native stderr output into errors.
$ErrorActionPreference = 'Continue'
Set-Location (Split-Path $PSScriptRoot -Parent)

$cfg = @{}
foreach ($line in Get-Content .env) {
    if ($line -match '^([A-Z0-9_]+)=(.*)$') { $cfg[$Matches[1]] = $Matches[2].Trim() }
}

docker compose up -d
if ($LASTEXITCODE -ne 0) { throw 'docker compose up failed. Is Docker Desktop running?' }

$exportArgs = @('scripts/export-static.php', "--source=$($cfg.WP_URL)", "--form-key=$($cfg.WEB3FORMS_KEY)")
if ($cfg.STATIC_URL) {
    $exportArgs += "--url=$($cfg.STATIC_URL)"
} else {
    Write-Host 'STATIC_URL is not set in .env: links will be root-relative and canonical/og:url tags relative.'
}
php @exportArgs
if ($LASTEXITCODE -ne 0) { throw 'Static export failed; nothing was deployed.' }

Copy-Item static\* dist\ -Recurse -Force

if ($Deploy) {
    if (-not (Test-Path .vercel\project.json)) { throw 'Not linked to Vercel: run `vercel link` in this folder first.' }
    Copy-Item .vercel dist\ -Recurse -Force
    vercel deploy dist --prod --yes
    if ($LASTEXITCODE -ne 0) { throw 'Vercel deploy failed.' }
}
