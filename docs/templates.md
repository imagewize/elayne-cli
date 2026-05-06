# Pattern Templates

Pre-built WordPress block pattern templates available for scaffolding with the `pattern:create` command.

## Available Templates

| Template | Description |
|---|---|
| `blank` | Empty pattern with header only |
| `hero-cover` | Full-bleed `wp:cover` with bottom-center content |
| `cta-fullwidth` | Full-width call-to-action band |
| `feature-grid-3col` | Full-width section with 3 feature cards |
| `stats-bar-fullwidth` | Dark full-width stats/numbers bar |
| `two-column-text-image` | Text left, image right two-column layout |
| `header-standard` | Standard header — logo, navigation, social links |
| `footer-standard` | Standard footer — brand blurb, nav columns, subnav |
| `testimonials-grid` | Responsive testimonial card grid with reviewer info |
| `pricing-comparison` | Three-tier pricing table with elevated recommended card |
| `blog-post-columns` | `wp:query`-driven 3-column post grid (portrait images) |
| `team-grid` | Team member profile grid — photo, name, title, bio |
| `woo-hero` | WooCommerce — two-column hero: text + CTA left, decorative cover right |
| `woo-ticker` | WooCommerce — server-rendered marquee ticker bar (needs `render_block` filter) |
| `woo-shop-categories` | WooCommerce — CSS bento grid: one large featured card + four smaller cards |
| `woo-featured-products` | WooCommerce — section header with View All + product-collection 4-col grid |
| `woo-our-story` | WooCommerce — two-column brand story: monogram watermark left, text + stats right |
| `woo-testimonials` | WooCommerce — three-column testimonial cards with star ratings and avatar circles |
| `woo-newsletter` | WooCommerce — full-bleed newsletter signup with decorative eyebrow |
| `woo-shop-landing` | WooCommerce — store homepage shell that composes sub-patterns in sequence |
| `woo-cart` | WooCommerce — full-width cart page wrapper (`Inserter: false`) |
| `woo-checkout` | WooCommerce — full-width checkout page wrapper (`Inserter: false`) |
| `woo-filters-sidebar` | WooCommerce — sticky sidebar: price slider + colour-chip attribute + two checkbox-list attributes |
| `woo-product-grid` | WooCommerce — filter-aware product-collection grid with sort toolbar + pagination |

## Usage

Use the `pattern:create` command to scaffold a new pattern from a template:

```bash
vendor/bin/elayne pattern:create --template=hero-cover
```

Or interactively:

```bash
vendor/bin/elayne pattern:create
```

Then select a template from the list when prompted.
