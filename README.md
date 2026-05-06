# Elayne CLI

CLI scaffolding tool for [Elayne](https://github.com/imagewize/elayne), a WordPress block theme. Generates WordPress block pattern PHP files, layout patterns, and theme style variation JSON files interactively from pre-built templates.

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
    "layout:create":  "@php ./vendor/bin/elayne layout:create",
    "style:create":   "@php ./vendor/bin/elayne style:create"
}
```

Then run `composer pattern:list`, `composer pattern:create`, `composer layout:create`, or `composer style:create`.

To use the bare `elayne` command from any project directory, add `./vendor/bin` to your shell PATH:

```bash
# ~/.zshrc or ~/.bashrc
export PATH="./vendor/bin:$PATH"
```

After reloading your shell (`source ~/.zshrc`) you can run `elayne pattern:list`, `elayne pattern:create`, `elayne layout:create`, and `elayne style:create` directly.

## Usage

### List available templates, snippets, layouts, categories, and style presets

```bash
vendor/bin/elayne pattern:list
```

### Scaffold a new pattern (interactive)

```bash
vendor/bin/elayne pattern:create
```

You will be prompted for pattern title, slug, category, template, keywords, and output directory. Use `--with-style` to also generate a companion CSS file, and `--shell-only` for an editor-first workflow (PHP header + paste marker only).

### Scaffold a new layout pattern (interactive)

```bash
vendor/bin/elayne layout:create
```

You will be prompted for pattern title, slug, layout type, category, keywords, and output directory. Use `--shell-only` for an editor-first workflow.

Example non-interactive usage:

```bash
vendor/bin/elayne layout:create \
  --title="Home Hero" \
  --slug="elayne/home-hero" \
  --layout=hero-image-right \
  --category=elayne/hero \
  --keywords="hero, home" \
  --output-dir=./patterns
```

### Scaffold a new style variation (interactive)

```bash
vendor/bin/elayne style:create
```

You will be prompted for style name, vertical preset (or custom colors), and output directory.

Example non-interactive usage:

```bash
vendor/bin/elayne style:create --name="Ocean Legal" --vertical=legal
```

### Non-interactive pattern creation

```bash
vendor/bin/elayne pattern:create \
  --title="My Pattern" \
  --slug="elayne/my-pattern" \
  --template=hero-cover \
  --category=elayne/hero \
  --keywords="hero, banner" \
  --output-dir=./patterns \
  --with-style \
  --style-dir=./assets/styles/block-styles
```

With `--shell-only` (editor-first workflow):

```bash
vendor/bin/elayne pattern:create \
  --title="My Pattern" \
  --slug="elayne/my-pattern" \
  --template=hero-cover \
  --category=elayne/hero \
  --shell-only
```

The `--slug` option accepts the full `elayne/<slug>` form or just the bare slug — the `elayne/` prefix is stripped automatically.

## Documentation

Detailed reference material is available in the [docs/](docs/) directory:

- [📄 Templates](docs/templates.md) — Available pattern templates and descriptions
- [📄 Layouts](docs/layouts.md) — Structural layout patterns for the `layout:create` command
- [📄 Snippets](docs/snippets.md) — Reusable block markup fragments
- [📄 Categories](docs/categories.md) — Available pattern categories
- [📄 CSS Stubs](docs/css-stubs.md) — CSS file generation and custom stubs
- [📄 Style Presets](docs/style-presets.md) — Theme style variation color palettes

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

GPL-2.0-or-later — see [LICENSE.md](LICENSE.md) for details.
