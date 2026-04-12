# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
