# DESIGN.md

Design spec for the portfolio theme. Coding agents: read this before touching
`wp-content/themes/jmc-portfolio`. Tokens are adapted from the Vercel DESIGN.md in
[VoltAgent/awesome-design-md](https://github.com/VoltAgent/awesome-design-md) (MIT), filtered
through the `design-taste-frontend` and `redesign-existing-projects` skills in `.claude/skills/`.

## Read

Stark, ink-on-near-white developer portfolio for recruiters. Type carries the page; no imagery
yet. Dials: variance 6, motion 3, density 4.

## Color

One gray family, one accent. The accent is reserved for the primary button, links, focus rings.

| Token (theme.json slug) | Light | Dark |
| --- | --- | --- |
| `base` (canvas) | #fafafa | #0b0b0c |
| `surface` (panels, inputs) | #ffffff | #111113 |
| `surface-2` | #f5f5f5 | #18181b |
| `line` (hairlines) | #ebebeb | #26272b |
| `field` (input borders) | #8f8f8f | #4a4b52 |
| `muted` | #6b6b6b | #8a8f98 |
| `body` (running text) | #4d4d4d | #c9ccd2 |
| `contrast` (ink, headings) | #171717 | #f2f2f3 |
| `accent` | #2f56d6 | #7b9bff |
| `on-accent` | #fafafa | #0b0b0c |

Dark mode follows `prefers-color-scheme`. No pure #000 / #fff. Sections never invert.

## Type

Geist for everything, Geist Mono for small technical text (dates, stacks). Both SIL OFL 1.1,
self-hosted. Weights 400 / 500 / 600; never 700.

| Role | Size | Line height | Tracking |
| --- | --- | --- | --- |
| Display (h1) | clamp(2.25rem, 1.5rem + 3vw, 3.5rem) | 1.05 | -0.04em |
| h2 | clamp(1.75rem, 1.4rem + 1.2vw, 2.25rem) | 1.15 | -0.03em |
| h3 | 1.25rem | 1.3 | -0.015em |
| Lead | 1.125rem | 1.6 | 0 |
| Body | 1rem | 1.6 | 0 |
| Small | 0.875rem | 1.5 | 0 |
| Mono | 0.8125rem | 1.5 | 0 |

Headings sentence case with `text-wrap: balance`; buttons Title Case. Body copy max 65ch.

## Space, shape, depth

4px base. Section padding 96px desktop / 64px mobile. Container 1120px, gutters 24px / 16px.
Radius: 6px controls, 12px panels. No pills. Depth comes from hairlines and surface steps, not
shadows.

## Sections (each a different layout family)

- **Header**: sticky, 64px, hairline bottom. Wordmark left, 4 links right.
- **Hero**: left-aligned type, no eyebrow, no glow. H1 at most 2 lines, subtext at most 20
  words, 1 primary button + 1 text link.
- **Work**: one featured project as a full-width panel, the rest as a hairline-divided list
  (title, one line, stack in mono). No numbering, no equal-card grid.
- **About**: one prose column plus skills as grouped plain text (no pills).
- **Experience**: grid `10rem 1fr`, mono date column, hairline per entry, no rail or dots.
- **Contact**: stacked. Heading, one sentence, email as a large accent link, form panel
  (max 560px) with labels above inputs.
- **Footer**: one row, name and year left, social icons right.

## Motion

150 to 200ms, `cubic-bezier(0.16, 1, 0.3, 1)`, transform / opacity / color only. Sections fade
up 12px on scroll via `animation-timeline: view()` where supported and only under
`prefers-reduced-motion: no-preference`. No glows, parallax or loops.

## Banned

Inter and Space Grotesk, radial glows, gradient text, mono uppercase eyebrows, numbered cards,
3-column equal cards, pill tags, em or en dashes in copy, filler verbs (elevate, seamless,
unleash), emoji, hotlinked images or fonts, fake screenshots built from divs.
