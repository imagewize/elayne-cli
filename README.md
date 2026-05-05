# Elayne CLI

CLI scaffolding tool for [Elayne](https://github.com/imagewize/elayne), a WordPress block theme. Generates WordPress block pattern PHP files and theme style variation JSON files interactively from pre-built templates.

## Requirements

- PHP >= 8.0
- Composer

## Installation

```bash
composer require imagewize/elayne-cli
```

Or clone and install locally:

```bash
git clone https://github.com/imagewize/elayne-cli.git
cd elayne-cli
composer install
```

## Shorter commands (optional)

Add these scripts to your theme's `composer.json` to avoid typing `vendor/bin/elayne` every time:

```json
"scripts": {
    "pattern:list":   "@php ./vendor/bin/elayne pattern:list",
    "pattern:create": "@php ./vendor/bin/elayne pattern:create",
    "style:create":   "@php ./vendor/bin/elayne style:create"
}
```

Then run `composer pattern:list`, `composer pattern:create`, or `composer style:create`.

To use the bare `elayne` command from any project directory, add `./vendor/bin` to your shell PATH:

```bash
# ~/.zshrc or ~/.bashrc
export PATH="./vendor/bin:$PATH"
```

After reloading your shell (`source ~/.zshrc`) you can run `elayne pattern:list`, `elayne pattern:create`, and `elayne style:create` directly.

## Usage

### List available templates, snippets, categories, and style presets

```bash
vendor/bin/elayne pattern:list
```

### Scaffold a new pattern (interactive)

```bash
vendor/bin/elayne pattern:create
```

You will be prompted for:

| Prompt | Notes |
|---|---|
| Pattern title | Human-readable label |
| Pattern slug | Auto-derived from title; prefixed with `elayne/` |
| Category | Choose from the built-in `elayne/*` categories |
| Template | Choose a starter layout (see below) |
| Keywords | Comma-separated, used for WP pattern search |
| Output directory | Defaults to `./patterns/` if it exists, otherwise `./` |

### Non-interactive (flags)

```bash
vendor/bin/elayne pattern:create my-slug \
  --title="My Pattern" \
  --template=hero-cover \
  --category=elayne/hero \
  --keywords="hero, banner" \
  --output-dir=./patterns
```

### Scaffold a style variation (interactive)

```bash
vendor/bin/elayne style:create
```

You will be prompted for:

| Prompt | Notes |
|---|---|
| Style name | Display name shown in the WP editor (e.g. "Ocean Legal") |
| Vertical | Choose a preset palette or enter custom hex values |
| Brand colors | 4 hex values — primary, accent, alt, alt-accent (preset defaults shown) |
| Output directory | Defaults to `./styles/` if it exists, otherwise `./` |

Non-interactive:

```bash
vendor/bin/elayne style:create --name="Ocean Legal" --vertical=legal
```

After generation, copy the `.json` file to your theme's `styles/` directory and activate it via **Appearance → Editor → Styles**.

## Templates

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

## Snippets

Reusable block markup fragments listed by `pattern:list`. Copy them into an existing pattern file as a starting point.

| Snippet | Description |
|---|---|
| `3col-grid-wrapper` | Responsive 3-column `wp:columns` wrapper — columns stack on mobile |
| `eyebrow-heading-body` | Eyebrow label + heading + body paragraph group for constrained sections |
| `overlay-grid-cover-card` | Portrait `wp:cover` card with a floating badge overlay — drop inside a `wp:column` |
| `stat-item` | Single stat (large number + label) for use inside a dark stats-bar column |
| `testimonial-card` | Testimonial card (quote, reviewer name, role) for a testimonials grid column |
| `two-button-group` | Primary + outline button pair (`wp:buttons`) for use after heading/body content |
| `valid-button-attr-order` | WP 6.6+ `wp:button` — root-level attrs (`className`, colors, `borderColor`) before `style`; filled and outline variants |
| `valid-columns-wp66` | WP 6.6+ `wp:columns` without inline `gap`/`margin`; equal and 55/45 split variants |
| `valid-cover` | WP 6.6+ `wp:cover` — solid color, gradient, and `dimRatio:0` variants with all required root-level attrs |
| `valid-fullwidth-section` | `alignfull` outer group with margin reset and constrained inner group |
| `valid-heading-with-preset` | `wp:heading` with `fontSize` slug + matching utility class; h1/h2/h3 variants |
| `responsive-grid-min-width` | `wp:group` grid layout using `minimumColumnWidth` — preferred over `wp:columns` for 3+ columns |

## Style variation presets

| Vertical | Colors |
|---|---|
| `custom` | Enter your own hex values |
| `legal` | Navy blue + gold |
| `plumbing` | Dark blue + orange |
| `spa` | Sage green + sand |
| `food-beverage` | Burgundy + gold |

The generated `styles/*.json` file defines the full color palette (`palette`, `gradients`, `duotone`) that maps to the Elayne theme's design tokens.

## Categories

```
header                 footer
elayne/hero            elayne/features        elayne/call-to-action
elayne/testimonial     elayne/team            elayne/statistics
elayne/contact         elayne/posts           elayne/pricing
elayne/banner          elayne/card-simple     elayne/card-extended
elayne/card-profiles   elayne/woocommerce
```

## Generated pattern file

The command writes a `.php` file to the output directory. Example output for a blank pattern:

```php
<?php
/**
 * Title: My Pattern
 * Slug: elayne/my-pattern
 * Description: My Pattern
 * Categories: elayne/hero
 * Keywords: hero, banner
 * Viewport Width: 1200
 * Block Types: core/group
 */
?>
```

After generation, add your block markup inside the file and flush the WordPress pattern cache.

## License

GPL-2.0-or-later — see [LICENSE](LICENSE) for details.
