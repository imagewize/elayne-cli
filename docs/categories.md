# Pattern Categories

Available WordPress pattern categories for the Elayne theme. Use these when creating new patterns to ensure proper organization in the WordPress pattern library.

## Available Categories

```
header                 footer
elayne/hero            elayne/features        elayne/call-to-action
elayne/testimonial     elayne/team            elayne/statistics
elayne/contact         elayne/posts           elayne/pricing
elayne/banner          elayne/card-simple     elayne/card-extended
elayne/card-profiles   elayne/woocommerce
```

## Usage

When creating a new pattern, select a category from the list above. For example:

```bash
vendor/bin/elayne pattern:create --category=elayne/hero
```

Or for layouts:

```bash
vendor/bin/elayne layout:create --category=elayne/features
```

## Custom Categories

You can also use standard WordPress core categories like `header`, `footer`, etc., or define your own custom categories as needed.
