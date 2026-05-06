# CSS Stubs

When the `--with-style` flag is passed to `pattern:create`, a companion CSS file is generated alongside the pattern PHP file. The CSS stub is loaded from the `css/` directory and tokens are replaced at generation time.

## Available CSS Stubs

| Stub | Used for | Description |
|---|---|---|
| `css/hero-cover.css` | `hero-cover` | Overlay tweaks and mobile full-width button stacking |
| `css/cta-fullwidth.css` | `cta-fullwidth` | Centres button row, stacks buttons full-width on mobile |
| `css/feature-grid-3col.css` | `feature-grid-3col` | Fixes `is-layout-flow` margin on grid cards, hover shadow transition |
| `css/testimonials-grid.css` | `testimonials-grid` | Fixes `is-layout-flow` margin, opening quote mark via `::before` |
| `css/team-grid.css` | `team-grid` | Fixes `is-layout-flow` margin, enforces 4:5 portrait aspect ratio on photos |
| `css/stats-bar-fullwidth.css` | `stats-bar-fullwidth` | Vertical dividers between stat items on desktop, top-border fallback on mobile |
| `css/woo-filters-sidebar.css` | `woo-filters-sidebar` | Full WooCommerce filter block CSS (sticky sidebar, price slider, checkbox lists, colour swatches) |
| `css/generic.css` | All other templates | Minimal skeleton scoped to `.elayne-{slug}` with a heading rule and mobile breakpoint |

## Token Replacement

The following tokens are replaced in CSS stubs during generation:

- `TODO-slug` → The pattern slug (e.g., `my-pattern`)
- `TODO-title` → The pattern title (e.g., `My Pattern`)

## Adding Custom CSS Stubs

To add CSS support for a new template:

1. Create a new file in the `css/` directory named `{template-name}.css`
2. Use `TODO-slug` and `TODO-title` as placeholders
3. No PHP changes are required — the CLI will automatically pick up the new stub

## Example CSS Stub

```css
/* css/my-template.css */
.elayne-TODO-slug {
    /* Styles for TODO-title */
    padding: 1rem;
}

.elayne-TODO-slug .wp-block-heading {
    color: inherit;
}
```

When generated with `--title="My Pattern" --slug="elayne/my-pattern"`, this becomes:

```css
/* Generated CSS file */
.elayne-my-pattern {
    /* Styles for My Pattern */
    padding: 1rem;
}

.elayne-my-pattern .wp-block-heading {
    color: inherit;
}
```
