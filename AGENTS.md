# AGENTS.md

## Project Overview
This repository is a custom **WordPress 7+ Block Theme** built from scratch. It uses Full Site Editing (FSE) templates, `theme.json` design tokens and block settings, and **Webpack** to bundle and minify CSS/SCSS, JavaScript, and custom Gutenberg blocks.

**Guiding Philosophy (Pragmatic & Lenient):**
- Prioritize clean, readable, maintainable code over rigid enterprise WordPress VIP/WPCS rules.
- Do **not** enforce Yoda conditions (`'value' === $var`), heavy docblock boilerplate on simple helpers, or brittle static React `save()` migrations when dynamic PHP rendering works better.
- Keep security non-negotiable (escaping, sanitization, nonces) and follow modern WordPress 7+ block standards (`apiVersion: 3`, `theme.json` v3, Interactivity API).
- **Theme settings over database blocks:** Prioritize making all theme, layout, and block modifications via `theme.json` (`settings` and `styles`) and version-controlled theme files (`templates/`, `parts/`, `patterns/`, `menus/`, `inc/`, `functions.php`). Do **not** rely on the WordPress database's block features (`wp_block` reusable/synced blocks, `wp_global_styles`, `wp_template`, `wp_template_part`, or `wp_navigation` post overrides) to store theme configuration or design changes.

---

## Directory Structure
Adjust paths below if your theme uses different folder names:
- `theme.json` — **Primary configuration layer (`"version": 3`)**. Single source of truth for global and per-block `settings` (colors, typography, spacing, layout widths, enabled block controls) and `styles` (core and custom block defaults).
- `style.css` — Theme header metadata required by WordPress (do not write theme styles here).
- `functions.php` — Theme setup, block auto-registration, Block Bindings/Hooks, and global asset enqueues.
- `templates/` — HTML block templates (`index.html`, `single.html`, `page.html`, `archive.html`, `404.html`).
- `parts/` — HTML template parts (`header.html`, `footer.html`).
- `patterns/` — PHP block patterns with standard WordPress file headers (use PHP for dynamic asset URLs and translatable strings; replaces database-stored reusable blocks).
- `inc/` — Modular PHP helpers (custom post types, Block Binding sources, Block Hooks, AJAX/REST handlers).
- `src/` — **Webpack source files**:
  - `src/scss/` & `src/js/` — Global theme styles and scripts.
  - `src/blocks/<block-name>/` — Custom blocks (`block.json`, `index.js`, `edit.js`, `render.php`, `view.js`, `style.scss`, `editor.scss`).
- `dist/` (or `build/`) — **Compiled & minified Webpack output**. WordPress loads compiled assets and `block.json` metadata from here.

---

## Asset & Block Build Pipeline (Webpack)
- **Install dependencies:** `npm install`
- **Development build / watch:** `npm run dev` (or `npm run watch`)
- **Production minified build:** `npm run build`

### Build Rules
1. **Never edit compiled files directly.** Anything inside `dist/` (or `*.min.js` / `*.min.css`) is overwritten by Webpack. Always edit files in `src/` and run `npm run build`.
2. **Copy block metadata & PHP templates.** Ensure Webpack copies `block.json` and `render.php` from `src/blocks/<block-name>/` into `dist/blocks/<block-name>/` alongside the compiled JS/CSS entry points.
3. **Register blocks from `dist/`.** Register compiled blocks in `functions.php` using `wp_register_block_types_from_metadata_collection()` (or loop `register_block_type()` over `dist/blocks/*`).
4. **ES Modules for frontend interactivity.** Output `viewScriptModule` files as ES Modules (`"type": "module"`) when using `@wordpress/interactivity` so WordPress loads them via the Script Modules API without blocking page render.
5. **Cache-busting.** Version any manually enqueued global styles/scripts with `filemtime()` on the compiled file path.

---

## WordPress 7+ Block Standards

### 1. Prioritize Theme Settings (`theme.json`) Over Database Blocks & Custom Blocks
Always solve design, behavior, and layout changes through theme settings and static theme files first:
- **Configure via `theme.json` `settings` & `styles`:** Control color palettes, fluid typography, spacing scales, layout constraints, block feature toggles, and per-block defaults (`settings.blocks.<block-name>` and `styles.blocks.<block-name>`) directly in `theme.json` (schema v3). Reference generated `--wp--preset--*` CSS custom properties in SCSS instead of hardcoding values.
- **Avoid database-stored block & Site Editor overrides:** Never treat database records (`wp_block` synced/reusable blocks, `wp_global_styles`, `wp_template`, `wp_template_part`, `wp_navigation`, or raw block markup in `wp_options`) as the source of truth. If adjustments are prototyped in the Site Editor, port them into `theme.json`, `templates/`, `parts/`, or `patterns/` and discard the database overrides.
- **File-based patterns over reusable DB blocks:** Build reusable sections as PHP files in `patterns/` using core blocks rather than saving synced blocks (`wp_block`) in the database or inventing rigid custom blocks.
- **Dynamic post meta / custom fields:** Use the **Block Bindings API** (`register_block_bindings_source()`) to bind core Paragraph, Heading, Image, or Button blocks to custom data before creating a custom block.

### 2. Custom Block Architecture
- **Use `apiVersion: 3`:** Every `block.json` must declare `"apiVersion": 3` so the block renders cleanly inside the iframed Site Editor and Post Editor.
- **Default to Dynamic Blocks (`render.php`):** Use `"render": "file:./render.php"` in `block.json` and return `null` from `save()` in JS. Server-side rendering avoids Gutenberg block validation errors and deprecation migrations when HTML markup evolves.
- **Always use `get_block_wrapper_attributes()`:** In `render.php`, output wrapper attributes on the root HTML element (`<div <?php echo get_block_wrapper_attributes(); ?>>`) so WordPress automatically applies spacing, color, typography, and alignment supports configured in `theme.json`.
- **Use the Interactivity API for frontend JS:** For interactive UI (tabs, accordions, modals, filters), use `@wordpress/interactivity` (`data-wp-interactive`, `data-wp-on--click`, `data-wp-bind--*`) with `viewScriptModule` in `block.json`. Avoid jQuery or manual `document.querySelectorAll` DOM scraping.

---

## Coding Conventions

### PHP & WordPress
- **Prefixing:** Prefix all global functions, custom block namespaces (`mytheme/hero`), Block Binding sources, and hooks with the theme slug to avoid plugin collisions.
- **Formatting:** Match the existing indentation and brace style in the file being edited. Standard readable comparisons (`if ($count === 0)`) are preferred over Yoda conditions.
- **Templates & Patterns:** Keep heavy queries and business logic out of `patterns/` and `render.php`. Put reusable queries in `inc/` helpers and call them cleanly.
- **Internationalization:** Wrap static user-facing strings in `esc_html__()` / `esc_html_e()` with the theme text domain.

### Security Basics (Required)
- **Escape on output:** Escape all dynamic data in `render.php` and `patterns/` using `esc_html()`, `esc_attr()`, `esc_url()`, or `wp_kses_post()`.
- **Sanitize on input:** Sanitize `$_GET`, `$_POST`, and `$_REQUEST` data with `sanitize_text_field()`, `absint()`, `sanitize_email()`, etc.
- **Nonces & Capabilities:** Verify nonces (`wp_verify_nonce()` / `check_ajax_referer()`) and capabilities (`current_user_can()`) on any form submission, REST route, or AJAX handler.
- **Database queries:** Use `$wpdb->prepare()` for any custom SQL queries.

### CSS & JavaScript
- Scope custom block styles to the block's generated `.wp-block-<namespace>-<block-name>` class.
- Keep editor-only overrides in `editor.scss` and shared frontend/editor styles in `style.scss`.
- Prefer modern ES6+ JavaScript and `@wordpress/*` packages (`@wordpress/blocks`, `@wordpress/block-editor`, `@wordpress/components`, `@wordpress/interactivity`).

---

## Git & Workflow
- Do not commit `node_modules/`, editor folders (`.idea/`, `.vscode/`), or `.DS_Store`.
- Confirm all styling, layout, and block setting updates are committed in `theme.json` and theme files rather than dependent on database-saved `wp_block` or Site Editor entries.
- Before finishing any task that modifies blocks, SCSS, or JS, verify that `npm run build` completes cleanly with zero Webpack errors.