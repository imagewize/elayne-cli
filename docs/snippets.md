# Snippets

Reusable block markup fragments that can be copied into existing pattern files as starting points. These are listed by the `pattern:list` command but are not used directly in file generation.

## Available Snippets

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

## Usage

List all available snippets:

```bash
vendor/bin/elayne pattern:list
```

Then copy the snippet content from the `snippets/` directory into your pattern file.
