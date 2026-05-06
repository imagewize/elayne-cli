# Layout Patterns

Ready-made WordPress block layout templates used by the `layout:create` CLI command. These serve as structural foundations for page design.

Source material is drawn from the Elayne theme pattern library (`elayne/patterns/`), which contains 127 patterns across structural templates, section components, and industry-specific patterns.

## Available Layouts

| Layout | Description |
|---|---|
| `full-width` | Single column, constrained — simplest starting point |
| `two-column` | 50/50 `wp:columns` block |
| `three-column` | CSS grid with 3 equal `wp:group` columns |
| `sidebar-left` | Narrow left sidebar (33%) + wide content area (66%) |
| `sidebar-right` | Wide content area (66%) + narrow right sidebar (33%) |
| `hero-image-left` | Cover image left + heading, text, CTA right |
| `hero-image-right` | Heading, text, CTA left + cover image right |
| `landing-page` | Hero section + 3-column features row + CTA — no header/footer wrapper |

## Usage

Scaffold a new layout pattern:

```bash
# Interactive
vendor/bin/elayne layout:create

# Non-interactive
vendor/bin/elayne layout:create --layout=hero-image-right --title="Home Hero"
```

---

## Reference Implementations

### Two Column

Using Columns Block:
```html
<!-- wp:columns -->
<!-- wp:column -->
Left content
<!-- /wp:column -->

<!-- wp:column -->
Right content
<!-- /wp:column -->
<!-- /wp:columns -->
```

### Three Column

Using Grid Block:
```html
<!-- wp:group {"layout":{"type":"grid"}} -->
<div class="wp-block-group">
<!-- wp:group -->
<div class="wp-block-group">Column 1</div>
<!-- /wp:group -->

<!-- wp:group -->
<div class="wp-block-group">Column 2</div>
<!-- /wp:group -->

<!-- wp:group -->
<div class="wp-block-group">Column 3</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
```

### Hero Layouts

#### Hero: Left Cover + Right Stacked Content
```html
<!-- wp:group {"layout":{"type":"grid"}} -->
<div class="wp-block-group">
<!-- wp:cover {"layout":{"type":"constrained"}} -->
<div class="wp-block-cover">
<span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim"></span>
<div class="wp-block-cover__inner-container">
<!-- wp:image -->
<figure class="wp-block-image"><img src="hero-image.jpg" alt=""/></figure>
<!-- /wp:image -->
</div>
</div>
<!-- /wp:cover -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
<!-- wp:heading -->
<h2 class="wp-block-heading">Heading</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Subheading text</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">Call to action</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
```

#### Hero: Cover Right + Left Stacked Content
```html
<!-- wp:group {"layout":{"type":"grid"}} -->
<div class="wp-block-group">
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
<!-- wp:heading -->
<h2 class="wp-block-heading">Heading</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Subheading text</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">Call to action</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:cover {"layout":{"type":"constrained"}} -->
<div class="wp-block-cover">
<span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim"></span>
<div class="wp-block-cover__inner-container">
<!-- wp:image -->
<figure class="wp-block-image"><img src="hero-image.jpg" alt=""/></figure>
<!-- /wp:image -->
</div>
</div>
<!-- /wp:cover -->
</div>
<!-- /wp:group -->
```

---

## Notes

- These are intentionally basic structural patterns using WordPress block markup
- Add classes, modifiers, and styles per project requirements
- Combine patterns as needed for complex pages
- The Elayne theme pattern library (`elayne/patterns/`) has 127 patterns: 16 structural page templates, ~80 section components, 11 WooCommerce patterns, and 31 industry-specific patterns (legal, plumbing, salon, spa, F&B)
