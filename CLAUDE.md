# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

`elayne-cli` is a Composer-based PHP CLI tool that scaffolds WordPress block pattern PHP files for the Elayne WordPress block theme. It uses Symfony Console to drive interactive prompts.

## Commands

```bash
composer install                    # Install dependencies
vendor/bin/elayne                   # Run CLI (defaults to pattern:list)
vendor/bin/elayne pattern:list      # Show available templates, snippets, and categories
vendor/bin/elayne pattern:create    # Interactively scaffold a new block pattern file
```

There are no test or lint scripts configured.

## Architecture

**Entry point:** `bin/elayne` bootstraps Composer autoload and runs `Application`.

**`src/Application.php`** extends Symfony's `Application`, registers two commands, and sets `pattern:list` as the default.

**`src/Commands/PatternCreateCommand.php`** is the main feature:
1. Interactively collects title, slug (auto-derived via `titleToSlug()`), category, template, keywords, and output directory.
2. Loads a template from `templates/` (or generates a blank one).
3. Replaces placeholder tokens and writes the PHP file to disk.

**`src/Commands/PatternListCommand.php`** renders a table of available templates, snippets, and category constants — purely informational.

## Template System

Templates live in `templates/` as `.php` files. They contain WordPress block markup (HTML comment syntax) with four placeholder tokens replaced at generation time:

| Token | Replaced with |
|---|---|
| `TODO: Pattern Title` | Human-readable title |
| `elayne/TODO-slug` | Pattern slug |
| `elayne/TODO-category` | Pattern category |
| `TODO keyword1, keyword2` | Keywords |

Reusable block snippets (standalone markup fragments) are in `snippets/` as `.txt` files and are listed by `pattern:list` but not used in file generation.

## Versioning

When bumping the package version, update it in **two places**:

1. **`src/Application.php`** — the version string passed to `parent::__construct()`.
2. **`CHANGELOG.md`** — add a new `## [x.y.z] - YYYY-MM-DD` section at the top of the changelog following Keep a Changelog conventions.

Do not update `composer.json` — the version there is managed by the Composer repository / Packagist tag.

## Git Conventions

- Use **atomic commits**: one logical change per commit. Always commit atomically — never batch unrelated changes.
- Commit messages must not mention AI tools or code assistants. Do not add `Co-Authored-By` trailers.
- Follow Conventional Commits format: `type: short description` (e.g. `feat:`, `fix:`, `docs:`, `chore:`).

## Key Conventions

- **Namespace:** `Imagewize\ElaynePatternCli\` (PSR-4, maps to `src/`)
- **PHP ≥ 8.0** — use typed properties and modern PHP idioms.
- Categories and available templates are defined as class constants in `PatternCreateCommand`.
- Generated files are standard WordPress block theme pattern PHP files with a docblock header (`Pattern Title`, `Slug`, `Categories`, `Keywords`).
