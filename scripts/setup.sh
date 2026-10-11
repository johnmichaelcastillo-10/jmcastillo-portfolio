#!/usr/bin/env bash
# Linux/macOS twin of setup.ps1. One-time local setup: creates .env, starts the containers,
# installs WordPress, activates the portfolio theme and plugin, and seeds the tagline and
# "Message sent" page.
# Safe to re-run; steps that are already done are skipped.
set -euo pipefail
cd "$(dirname "$0")/.."

fail() { echo "Error: $*" >&2; exit 1; }
secret() { LC_ALL=C tr -dc 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789' </dev/urandom | head -c 24 || true; }
wp() { docker compose run --rm cli wp "$@" || fail "wp $* failed"; }

if [[ ! -f .env ]]; then
    cp .env.example .env
    chmod 600 .env
    for key in WP_ADMIN_PASSWORD DB_PASSWORD DB_ROOT_PASSWORD; do
        # Not sed -i: its syntax differs between GNU and macOS.
        sed "s|^$key=.*|$key=$(secret)|" .env > .env.tmp && cat .env.tmp > .env && rm .env.tmp
    done
    echo 'Created .env with random passwords.'
fi

env_get() { { grep -E "^$1=" .env || true; } | tail -n 1 | cut -d= -f2- | tr -d '\r' | sed 's/[[:space:]]*$//'; }

docker info >/dev/null 2>&1 || fail 'cannot reach Docker. Start it (sudo systemctl start docker) and make sure your user is in the docker group.'
docker compose up -d || fail 'docker compose up failed.'

echo 'Waiting for WordPress to finish its first start...'
ready=false
for _ in $(seq 60); do
    if docker compose exec -T wordpress test -f /var/www/html/wp-config.php; then ready=true; break; fi
    sleep 2
done
$ready || fail 'WordPress did not create wp-config.php in time. Check: docker compose logs wordpress'

if ! docker compose run --rm cli wp core is-installed; then
    wp core install "--url=$(env_get WP_URL)" "--title=$(env_get WP_TITLE)" \
        "--admin_user=$(env_get WP_ADMIN_USER)" "--admin_password=$(env_get WP_ADMIN_PASSWORD)" \
        "--admin_email=$(env_get WP_ADMIN_EMAIL)" --skip-email
    wp plugin delete hello akismet
fi

wp theme activate jmc-portfolio
wp plugin activate jmc-portfolio-core
wp rewrite structure '/%postname%/'

wp eval-file /scripts/seed-content.php

echo
echo "Site:  $(env_get WP_URL)"
echo "Admin: $(env_get WP_URL)/wp-admin  (user: $(env_get WP_ADMIN_USER), password in .env)"
