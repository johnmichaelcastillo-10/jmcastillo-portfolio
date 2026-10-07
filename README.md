# Portfolio

Personal portfolio site built on WordPress, running locally in Docker.

The repo holds only the code that is ours:

| Path | What |
| --- | --- |
| `wp-content/themes/jmc-portfolio` | Block theme: design tokens (`theme.json`), templates, front-page sections (`patterns/`), self-hosted fonts, automatic dark mode |
| `wp-content/plugins/jmc-portfolio-core` | Projects + skills, project/resume link buttons, contact form block, social-preview meta tags |
| `DESIGN.md` | Design spec (palette, type, layout rules). Read it before changing the theme |
| `.claude/skills/` | Claude Code skills used for the design: taste, redesign, image-to-code, web-design-guidelines, playwright-cli |
| `docker-compose.yml` | WordPress (PHP 8.5) + MariaDB 12.3 + WP-CLI |
| `scripts/setup.ps1` | One-time install and sample content |

WordPress core, uploads and the database live in Docker volumes, not in git.

## Getting started

Requires Docker Desktop.

```powershell
.\scripts\setup.ps1
```

This creates `.env` with random passwords, starts the containers, installs WordPress,
activates the theme and plugin, and adds three sample projects.

- Site: http://localhost:8088
- Admin: http://localhost:8088/wp-admin (user `admin`, password in `.env`)

## Day to day

```powershell
docker compose up -d                      # start
docker compose stop                       # stop
docker compose run --rm cli wp <command>  # WP-CLI
docker compose down -v                    # delete everything, including the database
```

Theme and plugin folders are bind-mounted, so edits show up on refresh.

## Publishing (static, serverless)

WordPress only runs on this computer, as the editor. The public site is a static copy: plain
HTML, CSS, fonts and images, hosted on Netlify with no PHP or database online.

```powershell
.\scripts\publish.ps1            # build dist/ from the local site
php -S 127.0.0.1:8099 -t dist    # preview it at http://127.0.0.1:8099
.\scripts\publish.ps1 -Deploy    # build and deploy to Netlify
```

One-time Netlify setup:

1. `npx netlify-cli login`, then `npx netlify-cli sites:create` (or `link` to an existing site)
   in this folder.
2. In the Netlify site settings, turn on **Forms → Enable form detection**, then add an email
   notification under **Forms → Form notifications** so contact messages reach your inbox.
3. Put the site's address in `.env` as `STATIC_URL=https://<your-site>.netlify.app` (or your
   own domain) so canonical, share-preview and sitemap links are absolute.

On the static site the contact form is handled by Netlify Forms (with spam filtering and the
hidden honeypot field); after sending, visitors land on `/message-sent/`. Locally, the same
form still saves to Admin → Messages.

## Editing content

- **Projects:** Admin → Projects. Set a featured image, an excerpt (the card text) and skills.
  For the "View live site" and "Source code" buttons, open the editor's ⋮ menu →
  Preferences → General → Custom fields, then fill in `project_url` and `repo_url`.
  A button whose field is empty is hidden.
- **Resume button:** upload the PDF under Media, then paste its URL in Settings → General →
  Resume (PDF) URL. The hero's "Resume" button is hidden until this is set.
- **Contact form messages:** Admin → Messages. Every message is saved there first; email to the
  admin address is best-effort. Locally there is no mail server, so check Messages. On a live
  host, add an SMTP plugin if mail doesn't arrive.
- **Footer and contact links:** edit `patterns/footer.php` and `patterns/contact.php` in the theme.
- **Link previews:** the page description and preview image come from the site tagline, each
  project's excerpt and featured image, and the Site Icon (Settings → General). Installing an
  SEO plugin (Yoast, Rank Math) turns these tags off automatically.
- **Front page text:** Appearance → Editor → Templates → Front Page. Edits made there
  are stored in the database. To keep them in git, copy the changed markup back into
  `patterns/`, or export the theme with Appearance → Editor → ⋮ → Export.
