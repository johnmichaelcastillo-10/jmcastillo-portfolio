# CLAUDE.md

Project memory for Claude Code. Read this first; update it when something here stops being
true or a new non-obvious lesson is learned. Design rules live in `DESIGN.md`, setup steps in
`README.md`; this file holds what is expensive to rediscover.

## What this is

John Michael Castillo's personal portfolio: a WordPress block theme
(`wp-content/themes/jmc-portfolio`) plus a plugin (`wp-content/plugins/jmc-portfolio-core`:
projects, skills, contact form, résumé link, meta tags), running locally in Docker.
Hosting is not decided yet.

## Git and accounts (do not get wrong)

- Belongs to GitHub account **johnmichaelcastillo-10**, not the machine's default
  `jmcastillo-mets`. Remote is `git@github-jmc10:johnmichaelcastillo-10/portfolio.git`
  (SSH alias in `~/.ssh/config`, key `~/.ssh/github_johnmichaelcastillo10`). Repo-local
  `user.name` / `user.email` are set; never change them or use HTTPS for this remote.
- Never add `Co-Authored-By` or any AI attribution to commits.
- Work on `main`. The remote's old `master` branch is someone else's 2022 Coursera capstone
  ("Noha M."); never reuse anything from it. Switching GitHub's default branch to `main` is
  the user's job.
- Never commit `.env`, `backups/` or the résumé PDF (it contains a phone number).

## Run and verify

```powershell
docker compose up -d                                   # http://localhost:8088
docker compose run --rm cli wp <command>               # WP-CLI (PHP 8.5)
php -l <file>                                          # host PHP 8.5.11, lint only
```

- Port **8088**: 8080 belongs to another project's container on this machine.
- Stack: `wordpress:php8.5-apache`, `mariadb:12.3` (LTS, `MARIADB_AUTO_UPGRADE=1`),
  `wordpress:cli-php8.5`. WordPress core, uploads and the DB live in Docker volumes.
- Host PHP 8.5.11 lives in `%LOCALAPPDATA%\Programs\PHP\8.5` (official php.net zip, not
  winget); Composer in `%LOCALAPPDATA%\Programs\Composer`. The site never uses host PHP.
- `WP_DEBUG=1` prints PHP warnings into the HTML: after any change, fetch the pages and grep
  for `<b>Warning</b>` / `Deprecated` / `Fatal error`.
- Visual checks: `playwright-cli` (global install; skill in `.claude/skills/playwright-cli`)
  with `--browser=msedge`. Set `set-reduced-motion reduce` before full-page screenshots or the
  scroll-reveal leaves sections faded. Check light, dark (`set-color-scheme dark`) and 390px.
  Headless Edge's own `--window-size` can't go below ~500px; use `playwright-cli resize`.
- Code graph: Graphify (`uv tool install graphifyy`, project-scoped install). `graphify-out/`
  is gitignored, so after a fresh clone run `graphify update .` (local AST pass, no API cost).
  `.graphifyignore` keeps the vendored `.claude/skills/` out of the graph. Rules for using it
  are in the "graphify" section at the end of this file.

## Data

- `scripts/seed-content.php` (via `wp eval-file /scripts/seed-content.php`) **overwrites** the
  six projects and the tagline. Only `setup.ps1` should run it, on an empty site. Don't run it
  "to check something": it destroys wp-admin edits.
- Back up before anything risky. Dump inside the container and copy out, never pipe through
  PowerShell 5.1 (it re-encodes):
  `docker compose exec -T -e MYSQL_PWD=... db sh -c "mariadb-dump -u root --single-transaction --databases wordpress > /tmp/x.sql"`
  then `docker compose cp db:/tmp/x.sql backups/`.
- Content rule: only facts from the résumé (`Downloads\Castillo-Resume-Dev.pdf`). Never invent
  metrics, outcomes or promises. Ask the user for numbers.

## WordPress lessons learned here

- Shortcodes don't run inside a pattern placed in a template (shortcodes expand before
  patterns). Server features must be blocks; the contact form is `jmc-portfolio/contact-form`.
- New pattern files are invisible until the pattern cache expires unless
  `WP_DEVELOPMENT_MODE` is `theme` (set in `docker-compose.yml`).
- `wptexturize` turns `" - "` and digit ranges into en dashes. Copy bans dashes, so write
  "Since 2025", "Mar to May 2024".
- kses strips `<email>`-looking text from post titles; message titles use `Name — email`.
- Buttons bound to post meta / the résumé option (Block Bindings) render nothing when empty;
  see `includes/links.php`.
- Navigation and Social Icons blocks are banned on the front end (≈20 KB and ≈12 KB of inline
  CSS, plus the Interactivity API). Header nav is a Custom HTML `<nav>`.
- PowerShell 5.1: don't use `$ErrorActionPreference = 'Stop'` around docker (stderr progress
  becomes errors); check `$LASTEXITCODE` instead.

## Design

`DESIGN.md` is the source of truth (palette, Schibsted Grotesk + IBM Plex Mono, label-margin
layout, banned "AI look" patterns, engineering rules). Skills used to produce it are vendored
in `.claude/skills/` (taste, redesign, image-to-code, web-design-guidelines, playwright-cli).
Image generation (Higgsfield) costs credits: never use it without asking.

## Open items

- PHP 8.3 winget package half-uninstalled: VS Code's PHP IntelliSense held a file. With VS
  Code closed, run `winget uninstall --id PHP.PHP.8.3 -e`, then delete its leftover folder.
- Missing from the user: photo or sanitized screenshots, LinkedIn URL, résumé copy without
  the phone number, project numbers. Ask before adding the 3D warehouse digital twin or the
  Nuxt ERP rewrite (work projects; confidentiality unknown).
- Hosting choice, then SMTP for contact mail and analytics.

## graphify

This project has a knowledge graph at graphify-out/ with god nodes, community structure, and cross-file relationships.

Rules:
- For codebase questions, first run `graphify query "<question>"` when graphify-out/graph.json exists. Use `graphify path "<A>" "<B>"` for relationships and `graphify explain "<concept>"` for focused concepts. These return a scoped subgraph, usually much smaller than GRAPH_REPORT.md or raw grep output.
- If graphify-out/wiki/index.md exists, use it for broad navigation instead of raw source browsing.
- Read graphify-out/GRAPH_REPORT.md only for broad architecture review or when query/path/explain do not surface enough context.
- After modifying code, run `graphify update .` to keep the graph current (AST-only, no API cost).
