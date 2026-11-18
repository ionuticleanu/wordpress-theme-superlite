# SuperLite - *Wordpress Theme*

A modern, performance-focused WordPress block theme built to showcase Full Site Editing (FSE) and the native Gutenberg blocks paradigm. Engineered with a streamlined build pipeline, reusable block patterns, and clean architectural standards.

## Highlights

- **Performance-First Architecture:** Built with a lightweight footprint, clean semantic markup, and minimal runtime overhead to prioritize fast load times and strong Core Web Vitals.
- **Node.js & Webpack Build Pipeline:** Leverages the Node ecosystem and **Webpack** to bundle, optimize, and compress CSS and JavaScript assets for lean production delivery.
- **Full Site Editing (FSE):** Designed around the WordPress blocks paradigm, allowing visual customization of templates, template parts, headers, and footers directly in the Site Editor.
- **Global Styles (`theme.json`):** Centralized design tokens for typography, color palettes, spacing, and responsive layout widths.
- **Custom Block Patterns:** Modular, responsive section layouts ready to insert and customize across pages and posts.

## Getting Started

### Installation

Clone this repository into your WordPress `/wp-content/themes/` directory (or download the `.zip` archive and upload it via **Appearance → Themes → Add New**):

```bash
git clone https://github.com/ionuticleanu/wordpress-theme-superlite.git
```

Activate **SuperLite** from the WordPress admin dashboard, then open **Appearance → Editor** to customize templates, patterns, and global styles.

### Building Assets

To install dependencies and compile/compress CSS and JavaScript assets via `package.json`:

```bash
npm install
npm run build
```

## Author & Copyright

Copyright © Mădălin Ionuț Icleanu (just call me **John**) — explore more projects and work at [ionuticleanu.eu](https://ionuticleanu.eu).
