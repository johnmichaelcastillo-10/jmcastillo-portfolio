# DESIGN.md

Design system for the portfolio theme (`wp-content/themes/jmc-portfolio`). Coding agents:
read this before changing the theme. Tokens are theme.json presets (`--wp--preset--*`) plus
`--jmc-*` tokens at the top of `style.css`; components are classes in `style.css`.

## Concept

The copy presents the owner as a software developer in general (web applications and APIs);
employers appear only in Experience. The hero photo is a close-up of code. The palette is
the **Monochrome** group (Apple-like, minimal): #09090B · #18181B · #3F3F46 · #A1A1AA ·
#FAFAFA. There is no hue at all; the photos are the only colour on the page. The "accent"
(#18181B, #FAFAFA in dark mode) appears as the short bar on section labels, the headline
underline, the current-job timeline marker, the active-nav underline and list markers.

Credible-product polish without template tells: one photo-led hero, real content only (resume
facts, no invented metrics), restraint with effects (glass used once, on the stats card over
the photo; one faint dot-grid pattern, reused in the contact panel).

## Colour

| Role | Token | Light | Dark |
| --- | --- | --- | --- |
| Background | `base` | #fafafa | #09090b |
| Surface (cards) | `surface` | #ffffff | #18181b |
| Surface 2 (badges, fills) | `surface-2` | #f4f4f5 | #222226 |
| Border | `line` | #e4e4e7 | #2a2a2f |
| Field border / strong border | `field` | #a1a1aa | #3f3f46 |
| Muted text | `muted` | #71717a | #a1a1aa |
| Text | `body` | #3f3f46 | #d4d4d8 |
| Headings | `contrast` | #09090b | #fafafa |
| Primary | `primary` / `primary-soft` / `on-primary` | #18181b / #f4f4f5 / #fafafa | #fafafa / #27272a / #09090b |
| Accent | `accent` / `accent-soft` | #18181b / #f4f4f5 | #fafafa / #27272a |
| Success / Warning / Error / Info | `success` `warning` `error` `info` | #15803d #a15c07 #b42318 #3f3f46 | #4ade80 #fbbf24 #f87171 #a1a1aa |

Dark mode follows `prefers-color-scheme`. Shadows are tinted #09090B, never pure black.
#A1A1AA is only 2.5:1 on #FAFAFA, so in light mode it is used for borders, not text; muted
text there is #71717A (4.8:1). Red and green stay for error and success messages only.

## Type

Schibsted Grotesk (OFL, 400–700 variable) for everything; IBM Plex Mono (OFL) only for years
and the 404 code. Self-hosted. Display 2.5–4.5rem/1.04, weight 650, tracking -0.035em;
h2 1.875–2.75rem; h3 1.25rem; lead 1.1875rem; body 1rem/1.65; small 0.875rem; xs 0.8125rem.
Headings sentence case, `text-wrap: balance`.

## Space, shape, depth

Container 1180px wide, prose 720px. Section padding 4.5–7.5rem. Radius: 8 (controls),
12 (alerts, nav cards), 18 (cards, panels). Shadows: `--jmc-shadow-sm` at rest,
`-md` on hover, `-lg` for floating things (stats card, open menu).

## Components (style.css)

Buttons (`.wp-block-button` styles fill / `is-style-secondary` / `is-style-text`, and `.btn`
`.btn-secondary` `.btn-sm` for raw links; `btn-arrow`, `btn-external` add →/↗), badges
(`.badge`, `.badge-outline`, `.badge-accent`, `.badge-list` also styles post-terms), cards
(`.card`, project cards in `.project-cards`, `.is-bento` makes the first a 2×2 tile), icon chips,
alerts (`.alert-success` / `.alert-error`), form fields, breadcrumbs, empty states, pagination,
timeline, toolkit, stats card, footer.

Icons: inline SVG via `jmc_icon( 'name' )` from `assets/icons` (Lucide, ISC; GitHub from
Simple Icons, CC0). Decorative icons are `aria-hidden`.

## Sections

Header (sticky, blur, hairline on scroll; mobile menu behind a 44px button, see site.js) →
Hero (two columns: badge, display headline with the key phrase underlined, lead, actions; a
4:5 photo on an offset panel with the glass stats card hanging off its left edge) →
Work (split heading, bento cards; **only rendered when a personal project is published**,
work systems are confidential) → About (full-bleed surface band, prose + toolkit card) →
Experience (timeline cards on a rail, generic duties, education card) → Contact (the page's
one dark moment: a near-black panel, fixed colours in both schemes, with the form card
floating on it) → Footer (brand, two link columns, back to top).

Card photos share one grade (slightly desaturated, more contrast, faint ink wash) so photos
from different sources read as one set; hover restores full colour.

## Motion

150–240ms, `cubic-bezier(0.16, 1, 0.3, 1)`, transform / opacity / colour only. Hero settles in
once; content fades up on scroll via CSS `animation-timeline: view()` where supported; card
hover lifts 4px and zooms the photo 3.5%. All of it collapses under
`prefers-reduced-motion: reduce`; the form spinner stops spinning but stays visible.

## Images

Only CC0 or public-domain photos (via Openverse, `license=cc0,pdm`), so the site shows no
credits. Self-hosted WebP with alt text; sources are recorded in `assets/images/SOURCES.md`. Never hotlink, never use a licence that needs
attribution, avoid photos that show a real company's brand or identifiable faces.

## Rules that keep it fast

No Navigation or Social Icons blocks, no emoji script, no Interactivity API. Theme JS is
`assets/js/site.js` (menu + current section, ~2 KB) and the form's loading state. No
runtime dependencies.
