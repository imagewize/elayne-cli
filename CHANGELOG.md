# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.3.0] - 2026-05-03

### Added

- Ten WooCommerce store pattern templates promoted from the validated `feature/elayne-store` branch: `woo-hero-split`, `woo-ticker-band`, `woo-categories-bento`, `woo-product-grid`, `woo-text-image-watermark`, `woo-testimonials-grid`, `woo-newsletter-band`, `woo-landing-shell`, `woo-cart-page`, `woo-checkout-page`.
- New `elayne/woocommerce` pattern category registered in `PatternCreateCommand`.
- All woo-* templates include `TEMPLATE` and `RULES CHECKED` header comments and have TODO markers for all brand-specific content (headlines, copy, category names, stats, reviewer info).
- `woo-ticker-band` notes the required `render_block` filter dependency; `woo-categories-bento` notes the `is-style-elayne-woo-categories-grid` block style registration; `woo-landing-shell` notes that sub-pattern slugs must be updated to match the target vertical.

## [1.2.0] - 2026-04-13

### Added

- New `overlay-grid-cover-card` snippet — portrait cover image card with a floating bottom-left badge, implemented via `wp:cover` (not `wp:image`) for automatic landscape-to-portrait cropping. Includes inline usage notes for required theme CSS and editor display-fix rules.
- `overlay-grid-cover-card.txt` registered in `pattern:list` snippet table with a descriptive label.

## [1.1.0] - 2026-04-12

### Added

- `style:create` command — interactively scaffolds a WordPress theme style variation JSON file (`styles/*.json`) with a pre-wired color palette, gradients, and duotone entries. Supports five preset verticals (`legal`, `plumbing`, `spa`, `food-beverage`, `custom`) with per-field hex color prompts and defaults. Writes to `./styles/` by default; overridable with `--output-dir`.
- Six new pattern templates: `header-standard`, `footer-standard`, `testimonials-grid`, `pricing-comparison`, `blog-post-columns`, `team-grid`.
- Four new pattern categories: `header`, `footer`, `elayne/pricing`, `elayne/banner`.
- Style Variations section added to `pattern:list` output showing available vertical presets.
- Documented shorter Composer script aliases (`composer pattern:list`, `composer pattern:create`, `composer style:create`) and PATH-based `elayne` shorthand in README.

## [1.0.1] - 2026-04-12

### Added

- `README.md` with full usage guide, template table, category list, and generated file example.
- `CLAUDE.md` with project overview, architecture notes, template system docs, and git conventions.
- `CHANGELOG.md` to track notable changes per Semantic Versioning.
- `.gitignore` excluding `vendor/`, `composer.lock`, and `create-pr.sh`.

## [1.0.0] - 2026-04-12

### Added

- `pattern:create` command — interactive scaffolding of WordPress block pattern PHP files with title, slug, category, template, keywords, and output-directory prompts; all options also available as CLI flags for non-interactive use.
- `pattern:list` command — lists available templates, snippets, and pattern categories in a formatted table; set as the default command.
- Five starter templates: `hero-cover`, `cta-fullwidth`, `feature-grid-3col`, `stats-bar-fullwidth`, `two-column-text-image`.
- `blank` template fallback that generates a minimal pattern PHP docblock.
- Five reusable block snippets in `snippets/`.
- Eleven built-in pattern categories under the `elayne/*` namespace.
- Auto-slug derivation from pattern title via `titleToSlug()`.
- Overwrite confirmation prompt when target file already exists.
- Auto-creation of the output directory if it does not exist.
