# DESIGN.md

Design spec for the portfolio theme. Coding agents: read this before touching
`wp-content/themes/jmc-portfolio`. Built with the `design-taste-frontend`,
`redesign-existing-projects` and `web-design-guidelines` skills in `.claude/skills/`.

## Read

A personal page that reads as written, not generated. One tight column, a label in the left
margin for each section, an intro sentence instead of a headline-and-buttons hero, and lists
instead of cards. Dials: variance 5, motion 3, density 4.

What makes it not look machine-made, and must be kept:

- No default "AI stack" tells: not Inter or Geist, not a blue accent, no glows, no cards grid,
  no centered hero with two buttons, no uppercase mono eyebrows.
- Copy is first person and specific to the work. Links sit inside sentences.
- Small type, generous margins, warm paper instead of pure white.

## Color

| Token (theme.json slug) | Light | Dark |
| --- | --- | --- |
| `base` (paper) | #f9f8f6 | #121110 |
| `surface` (inputs) | #ffffff | #1a1917 |
| `surface-2` (row hover, notices) | #f1efeb | #22201e |
| `line` | #e6e3de | #2c2a27 |
| `field` (input hover border) | #a8a29b | #57534e |
| `muted` (labels, secondary text) | #736d66 | #9a948c |
| `body` | #3d3a36 | #d6d2cc |
| `contrast` (ink) | #181715 | #f3f1ee |
| `accent` | #c2410c | #fb923c |

The orange accent only appears on hover, focus rings and the submit button's hover. Links are
ink with a faint underline. Dark mode follows `prefers-color-scheme`.

## Type

Schibsted Grotesk (OFL) for text, IBM Plex Mono (OFL) only for years and dates. Self-hosted.

| Role | Size | Weight | Notes |
| --- | --- | --- | --- |
| Intro (h1) | clamp(1.5rem, 1.1rem + 1.6vw, 2.125rem) | 500 | line-height 1.28, tracking -0.025em; second sentence in `muted` |
| Section label (h2) | 0.875rem | 500 | `muted`, sticky in the margin |
| Item title (h3) | 1rem | 600 | ink |
| Body | 1rem | 400 | line-height 1.65 |
| Small | 0.875rem | 400 | |
| Mono | 0.8125rem | 400 | years, dates |

Headings sentence case, buttons and links Title Case. No em or en dashes in copy; date ranges
are written out ("Since 2025").

## Layout

Wide size 880px, content column 640px, label column 9.5rem. Below 720px the label stacks above
its content. Rows align on the text baseline. Section padding about 48px; intro top padding up
to 136px.

## Components

- **Intro**: h1 sentence plus three inline text links (Résumé, GitHub, Email). External links
  get a small ↗ that nudges on hover.
- **Work**: list rows (title, year right-aligned, one-line summary). The whole row is the link;
  hover tints the row with `surface-2`.
- **About**: two short paragraphs, then skills as labelled rows divided by hairlines.
- **Experience**: year column beside role, organisation and one paragraph.
- **Contact**: one sentence with the email inline, then a two-column form (name, email) with
  the message full width. Inputs 44px tall, 8px radius.
- **Footer**: hairline, name and year, social icons.

## Motion

The intro rises 10px and fades in once on load. Sections fade up as they scroll into view via
`animation-timeline: view()` where supported. Hovers are 150 to 200ms with
`cubic-bezier(0.16, 1, 0.3, 1)`. Everything is off under `prefers-reduced-motion: reduce`.
