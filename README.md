# Elayne CLI

CLI scaffolding tool for [Elayne](https://github.com/imagewize/elayne), a WordPress block theme. Generates WordPress block pattern PHP files interactively from pre-built templates.

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

## Usage

### List available templates, snippets, and categories

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

## Templates

| Template | Description |
|---|---|
| `blank` | Empty pattern with header only |
| `hero-cover` | Full-bleed `wp:cover` with bottom-center content |
| `cta-fullwidth` | Full-width call-to-action band |
| `feature-grid-3col` | Full-width section with 3 feature cards |
| `stats-bar-fullwidth` | Dark full-width stats/numbers bar |
| `two-column-text-image` | Text left, image right two-column layout |

## Categories

```
elayne/hero            elayne/features        elayne/call-to-action
elayne/testimonial     elayne/team            elayne/statistics
elayne/contact         elayne/posts           elayne/card-simple
elayne/card-extended   elayne/card-profiles
```

## Generated file

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
