# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.5.0] - 2026-05-05

### Added

- `pattern:create`: `--with-style` flag to generate a companion CSS file for the pattern, and `--style-dir` option to specify the CSS output directory (default: `assets/styles/block-styles/`).
- `woo-filters-sidebar` template: sticky sidebar pattern with price slider, colour-chip attribute, and two checkbox-list attribute filters.
- `woo-product-grid` template: filter-aware product-collection grid with sort toolbar and pagination.
- `css/` directory of CSS stub files used by `--with-style`: `css/{template}.css` is loaded when it exists, falling back to `css/generic.css`; tokens `TODO-slug` and `TODO-title` are replaced at generation time. Adding CSS for a new template requires only dropping a file in `css/` — no PHP changes needed.
- `css/woo-filters-sidebar.css`: full CSS skeleton for WooCommerce product filter blocks — sticky sidebar positioning, CSS custom properties for the price slider and checkbox list, filter group dividers, heading typography, price label inputs, checkbox list sizing, colour swatch chips, and mobile overlay hiding.
- `css/generic.css`: minimal skeleton scoped to `.elayne-{slug}` with a heading rule and a mobile breakpoint, used as the fallback for any template without a dedicated stub.

### Changed

- `README.md`: added `woo-filters-sidebar` and `woo-product-grid` templates to the template table; documented `--with-style` and `--style-dir` options for `pattern:create`; added CSS Stubs section.
- `PatternCreateCommand::buildStyleCss()`: replaced hardcoded PHP heredocs with a file-based dispatcher that loads from `css/{template}.css` (falling back to `css/generic.css`) and warns when no stub is found.

## [1.4.4] - 2026-05-05

### Added

- `pattern:create`: `--slug` named option so callers can pass `--slug=elayne/my-pattern` or `--slug=my-pattern` without relying on the positional argument. Accepts the full `elayne/` prefixed form and strips the prefix automatically before normalization.

## [1.4.3] - 2026-05-05

### Fixed

- `bin/elayne`: replaced hardcoded autoloader paths with a directory walk-up that searches for `vendor/autoload.php` from `bin/` upward. Works correctly both in standalone mode and when installed as a Composer dependency, regardless of nesting depth.

## [1.4.2] - 2026-05-05

### Fixed

- `bin/elayne`: autoloader discovery now falls back to the root project's `vendor/autoload.php` when the package is installed as a Composer dependency. Previously the script required `__DIR__ . '/../vendor/autoload.php'` which only exists in standalone mode, causing a fatal error when `composer pattern:create` was run from the theme directory.

## [1.4.1] - 2026-05-05

### Changed

- `README.md`: added Snippets section documenting all twelve reusable block markup fragments available via `pattern:list`.

## [1.4.0] - 2026-05-05

### Added

- Six WP 6.6+ block validation guard snippets in `snippets/`:
  - `valid-cover.txt` — three `wp:cover` variants (solid color, gradient, dimRatio:0) with all required root-level attrs (`minHeight` integer, `minHeightUnit`, `dimRatio` integer, `backgroundColor`/`customGradient`) and correct `has-background-dim-{N}` span classes.
  - `valid-columns-wp66.txt` — `wp:columns` without inline `gap`/`margin`; uses `isStackedOnMobile:false` → `is-not-stacked-on-mobile` class; includes equal and 55/45 split variants.
  - `responsive-grid-min-width.txt` — `wp:group` grid layout with `minimumColumnWidth` (the preferred pattern for 3+ columns over `wp:columns`); reference table of `rem` values by card complexity.
  - `valid-button-attr-order.txt` — `wp:button` with root-level attrs (`className`, `backgroundColor`, `textColor`, `borderColor`) before `style`; font size via `style.typography.fontSize` (not root `fontSize`); filled + outline variants with button-pair wrapper.
  - `valid-fullwidth-section.txt` — `alignfull` outer group with margin reset (`top`/`bottom` as `"0"` without units) and horizontal padding on outer; constrained inner group for content width.
  - `valid-heading-with-preset.txt` — `wp:heading` with `fontSize` slug in JSON and matching `has-{slug}-font-size` utility class in HTML; h1/h2/h3 variants across the store font-size scale.

### Fixed

- `PatternListCommand`: corrected WooCommerce template names to match actual file names — the list had been showing the pre-rename display names (`woo-hero-split`, `woo-ticker-band`, `woo-categories-bento`, `woo-product-grid`, `woo-text-image-watermark`, `woo-testimonials-grid`, `woo-newsletter-band`, `woo-landing-shell`, `woo-cart-page`, `woo-checkout-page`) instead of the current file names used by `PatternCreateCommand` (`woo-hero`, `woo-ticker`, `woo-shop-categories`, `woo-featured-products`, `woo-our-story`, `woo-testimonials`, `woo-newsletter`, `woo-shop-landing`, `woo-cart`, `woo-checkout`).

## [1.3.2] - 2026-05-03

### Fixed

- `testimonials-grid`: added `wp:image` avatar block (avatar-1 through avatar-4) to each reviewer card, matching the structure added to the theme.

### Changed

- `blog-post-columns`: cleared `Block Types` header field, added empty `Block Types` and `Post Types` lines; added `patternName` to root block metadata.
- `team-grid`: replaced `Block Types`/`Inserter` header fields with a `Grid Config` comment; added `patternName` to root block metadata.
- `pricing-comparison`: replaced `Block Types`/`Inserter` header fields with a `Grid Config` comment; added `patternName` to root block metadata.
- Renamed ten woo-* templates to match shorter filenames used in the theme: `woo-cart-page` → `woo-cart`, `woo-checkout-page` → `woo-checkout`, `woo-hero-split` → `woo-hero`, `woo-ticker-band` → `woo-ticker`, `woo-categories-bento` → `woo-shop-categories`, `woo-product-grid` → `woo-featured-products`, `woo-text-image-watermark` → `woo-our-story`, `woo-testimonials-grid` → `woo-testimonials`, `woo-newsletter-band` → `woo-newsletter`, `woo-landing-shell` → `woo-shop-landing`.
- Updated `TEMPLATES` constant keys in `PatternCreateCommand` to reflect the renamed woo templates.

## [1.3.1] - 2026-05-03

### Fixed

- Nine non-WooCommerce templates updated to pass pattern compliance checks: `blog-post-columns`, `cta-fullwidth`, `feature-grid-3col`, `footer-standard`, `hero-cover`, `pricing-comparison`, `stats-bar-fullwidth`, `testimonials-grid`, `two-column-text-image`.
- Added missing inline `gap:` style on flex group divs (`blog-post-columns`, `footer-standard`, `testimonials-grid`).
- Removed organizational HTML comments from inside block div elements — they cause WordPress block validation errors (`cta-fullwidth`, `hero-cover`, `two-column-text-image`).
- Replaced `wp:columns` 3-column layouts with responsive `wp:group` grid (`minimumColumnWidth`) in `feature-grid-3col` and `stats-bar-fullwidth`.
- Migrated `wp:button` root-level `fontSize` to `style.typography.fontSize` and removed `opacity` inline style in `pricing-comparison`.
- Converted commented-out image placeholder to a proper `wp:image` block in `two-column-text-image`.

### Changed

- `CLAUDE.md` git conventions: clarified atomic-commit requirement and prohibited `Co-Authored-By` trailers in commit messages.

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
