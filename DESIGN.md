# DESIGN.md

Design system for the portfolio theme (`wp-content/themes/jmc-portfolio`). Coding agents:
read this before changing the theme. Tokens are theme.json presets (`--wp--preset--*`) plus
`--jmc-*` tokens at the top of `style.css`; components are classes in `style.css`.

## Concept

Built from the owner's work: warehouse and cold-storage systems. The hero photo is a
pallet-rack aisle; its **steel-blue uprights** are the primary colour and its **orange beams**
the accent. The accent appears as the short "beam" bar on section labels, the current-job
timeline marker, the active-nav underline and list markers. Nowhere else.

Credible-product polish without template tells: one photo-led hero, real content only (résumé
facts, no invented metrics), restraint with effects (glass used once, on the stats card over
the photo; one faint dot-grid pattern, reused in the contact panel).

## Colour

| Role | Token | Light | Dark |
| --- | --- | --- | --- |
| Background | `base` | #f7f7f5 | #0d1117 |
| Surface (cards) | `surface` | #ffffff | #141a22 |
| Surface 2 (badges, fills) | `surface-2` | #f0f1ef | #1b222c |
| Border | `line` | #e3e4e1 | #262f3b |
| Field border / strong border | `field` | #b5b8b2 | #3d4756 |
| Muted text | `muted` | #636b78 | #8d97a7 |
| Text | `body` | #363d48 | #c6ccd6 |
| Headings | `contrast` | #11151b | #f1f3f6 |
| Primary (rack steel) | `primary` / `primary-soft` / `on-primary` | #1f4a8a / #e8eef7 / #fff | #7fa7ec / #16233a / #0d1117 |
| Accent (beam orange) | `accent` / `accent-soft` | #c2410c / #fdeee5 | #fb8c3c / #2c1a0e |
| Success / Warning / Error / Info | `success` `warning` `error` `info` | #15803d #a15c07 #b42318 #1d4ed8 | #4ade80 #fbbf24 #f87171 #60a5fa |

Dark mode follows `prefers-color-scheme`. Shadows are ink-tinted, never pure black.

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
Hero (badge, display headline, lead, primary + secondary + text action, photo with stats card) →
Work (split heading, bento cards) → About (full-bleed surface band, prose + toolkit card) →
Experience (timeline cards on a rail, education card) → Contact (panel: methods list + form
card) → Footer (brand, two link columns, credits + back to top).

## Motion

150–240ms, `cubic-bezier(0.16, 1, 0.3, 1)`, transform / opacity / colour only. Hero settles in
once; content fades up on scroll via CSS `animation-timeline: view()` where supported; card
hover lifts 4px and zooms the photo 3.5%. All of it collapses under
`prefers-reduced-motion: reduce`; the form spinner stops spinning but stays visible.

## Images

Real photos under CC BY via Openverse, self-hosted WebP, alt text from
`scripts/media/credits.json`. Credit is shown under the hero and project-page images and on
the Photo credits page (linked in the footer). Never hotlink, never drop a credit, avoid
photos that show a real company's brand.

## Rules that keep it fast

No Navigation or Social Icons blocks, no emoji script, no Interactivity API. Theme JS is
`assets/js/site.js` (menu + current section, ~2 KB) and the form's loading state. No
runtime dependencies.
