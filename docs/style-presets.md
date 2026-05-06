# Style Variation Presets

Pre-configured color palettes for generating WordPress theme style variation JSON files with the `style:create` command.

## Available Presets

| Vertical | Colors | Description |
|---|---|---|
| `custom` | Enter your own hex values | Full customization of all color values |
| `legal` | Navy blue + gold | Professional color scheme for legal/finance sites |
| `plumbing` | Dark blue + orange | Bold, masculine colors for trade services |
| `spa` | Sage green + sand | Calm, natural palette for wellness businesses |
| `food-beverage` | Burgundy + gold | Rich, appetizing colors for restaurants and food brands |

## Color Structure

Each preset defines the following color values:

- **Brand colors**: 4 hex values — primary, accent, alt, alt-accent
- **Full palette**: `palette`, `gradients`, `duotone` mappings

These map to the Elayne theme's design tokens for consistent styling.

## Usage

### Interactive

```bash
vendor/bin/elayne style:create
```

Select a vertical preset when prompted, or choose `custom` to enter your own hex values.

### Non-interactive

```bash
# Use a preset
vendor/bin/elayne style:create --name="My Brand" --vertical=legal

# Custom colors
vendor/bin/elayne style:create --name="Custom" --vertical=custom
```

## Generated Output

The command writes a `.json` file to your specified output directory (default: `./styles/`). After generation:

1. Copy the `.json` file to your theme's `styles/` directory
2. Activate it via **Appearance → Editor → Styles** in WordPress

## Example: Legal Preset

```json
{
  "version": 1,
  "isGlobalStylesUserThemeJSON": true,
  "title": "Legal",
  "settings": {
    "color": {
      "palette": {
        "theme": [
          {"slug": "primary", "color": "#001f3f"},
          {"slug": "accent", "color": "#ffbf00"},
          {"slug": "alt", "color": "#003366"},
          {"slug": "alt-accent", "color": "#cca300"}
        ]
      }
    }
  }
}
```
