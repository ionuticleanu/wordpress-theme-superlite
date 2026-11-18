# SuperLite - *Wordpress Theme*

A modern, performance-focused WordPress block theme built to showcase Full Site Editing (FSE) and the native Gutenberg blocks paradigm. Engineered with a streamlined build pipeline, reusable block patterns, and clean architectural standards.

## Highlights

- **Performance-First Architecture:** Built with a lightweight footprint, clean semantic markup, and minimal runtime overhead to prioritize fast load times and strong Core Web Vitals.
- **Node.js & Webpack Build Pipeline:** Leverages the Node ecosystem and **Webpack** to bundle, optimize, and compress CSS and JavaScript assets for lean production delivery.
- **Full Site Editing (FSE):** Designed around the WordPress blocks paradigm, allowing visual customization of templates, template parts, headers, and footers directly in the Site Editor.
- **Global Styles (`theme.json`):** Centralized design tokens for typography, color palettes, spacing, and responsive layout widths.
- **Custom Block Patterns:** Modular, responsive section layouts ready to insert and customize across pages and posts.

## Requirements

- **WordPress:** 6.7 or higher (tested up to 7.1)
- **PHP:** 7.2 or higher
- **Node.js & npm:** Required to install build dependencies and compile assets (`dist/` is not committed to Git)

## Getting Started

### 1. Install the Theme

Clone this repository into your WordPress `wp-content/themes/` directory as `superlite` (or upload a `.zip` archive via **Appearance → Themes → Add New**):

```bash
cd /path/to/wordpress/wp-content/themes
git clone https://github.com/ionuticleanu/wordpress-theme-superlite.git superlite
cd superlite
```

### 2. Install Dependencies & Build Assets

Because `dist/` is gitignored, you must compile the theme's CSS and JavaScript assets before using it:

```bash
npm install
npm run build
```

This step automatically generates `src/scss/_global-styles.scss` from `theme.json` and compiles, purges (via PurgeCSS), and minifies `dist/css/main.css` and `dist/js/main.js` (along with any custom blocks in `src/blocks/`).

### 3. Activate & Configure WordPress

1. **Activate the theme:** Go to **Appearance → Themes** in the WordPress admin dashboard and activate **SuperLite** (or run `wp theme activate superlite`).
2. **Enable pretty permalinks (required):** Go to **Settings → Permalinks**, choose **Post name** (or any non-Plain structure), and click **Save Changes**. This ensures the file-based routes (`/services/`, `/about/`, `/contact/`) and navigation menu links work properly.
3. **Configure Site Identity (optional):** Set your **Site Title** and **Tagline** under **Settings → General**, and optionally upload a **Site Logo** in **Appearance → Editor**.
4. **Homepage & boilerplate pages:** Leave **Settings → Reading → Your homepage displays** set to **Your latest posts** (the WordPress default) to automatically render `pages/front-page.php` on `/` along with `pages/services.php`, `pages/about.php`, and `pages/contact.php`. To convert any boilerplate page into an editable WordPress database page, view it while logged in and click **Edit Page (Save to DB)** in the admin bar.

### Development Scripts

- `npm run dev` — Starts Webpack in watch mode and automatically resyncs `src/scss/_global-styles.scss` whenever `theme.json` changes.
- `npm run build` — Runs the production build (syncs `theme.json` CSS, runs PurgeCSS + cssnano, and minifies assets into `dist/`).
- `npm run sync:theme-css` — Regenerates `src/scss/_global-styles.scss` from `theme.json` without running a full Webpack build.
- `npm run format` — Formats source files using `@wordpress/scripts`.

## Author & Copyright

Copyright © Mădălin Ionuț Icleanu (just call me **John**) — explore more projects and work at [ionuticleanu.eu](https://ionuticleanu.eu).
