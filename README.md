# Custom Theme — WordPress Block Theme Boilerplate

A classic (non-FSE) WordPress theme boilerplate built around Gutenberg blocks, TypeScript, and Sass. It uses `@wordpress/scripts`/Webpack for asset building and BrowserSync for live reload, and restricts the block editor to a curated set of custom blocks.

## Requirements

- Node.js >= 18.12.0 (required by `@wordpress/scripts`) and npm
- A local WordPress install (this repo is the theme, dropped into `wp-content/themes/`)
- PHP 8+ (uses typed properties / arrow functions in places)

## Getting started

1. Clone/copy this repo into `wp-content/themes/` of your WordPress install.
2. Install JS dependencies:

   ```bash
   npm install
   ```
3. Update the BrowserSync proxy URL in [webpack.config.js](webpack.config.js) to match your local site URL (defaults to `http://localhost/wp-block-theme-boilerplate/`).
4. Activate the theme ("Custom Theme") from the WordPress admin.

## Development

| Command | Description |
| --- | --- |
| `npm run dev` | Builds the blocks manifest, then runs Webpack in watch mode (development). |
| `npm start` | Runs `webpack serve` with BrowserSync, opens the browser automatically. |
| `npm run build` | Cleans `build/` and creates a production bundle. |
| `npm run clean` | Removes the `build/` directory. |
| `npm run build-block-manifest` | Regenerates `src/blocks/blocks-manifest.php` from the blocks in `src/`. |

All compiled assets are output to `build/`, mirroring the structure of `src/`.

## Project structure

```
├── classes/                  Custom PHP classes (e.g. nav menu walker)
├── inc/                       Theme includes (setup, template tags/functions, blocks, shortcodes, post types, taxonomies, sidebars, theme settings)
├── src/
│   ├── admin/                 Admin-only JS/Sass
│   ├── editor/                Block editor JS/Sass (editor-styles)
│   ├── blocks/                 Custom Gutenberg blocks (block.json, edit/save/render, styles)
│   ├── components/            Reusable front-end components (TS + Sass)
│   ├── layout/                Header/footer/sidebar assets (TS + Sass)
│   ├── styles/                 Shared Sass (abstracts, base, layout, utilities, vendors)
│   ├── assets/                 Static images/SVGs (SVGs are bundled into a sprite)
│   └── main.ts                 Front-end entry point
├── template-parts/            Template partials (content, excerpt, header, footer, components)
├── templates/                  Block/page templates (front page, home, sidebar layouts)
├── functions.php, header.php, footer.php, index.php, page.php, single.php,
│   archive.php, search.php, sidebar.php, 404.php   Standard WP template files
└── style.css                   Theme stylesheet header (name, version, text domain)
```

## Assets & enqueueing

Webpack auto-detects every `.ts`/`.js` file under `src/` as its own entry point (see [webpack.config.js](webpack.config.js)), so file layout under `src/` maps directly to `build/`. `functions.php` enqueues bundles per context via a shared `CustomTheme\enqueue_assets()` helper (see [inc/utilities.php](inc/utilities.php)):

- `admin` — WP admin screens (`admin_enqueue_scripts`)
- `editor` — block editor (`wp_enqueue_editor`)
- `main` — global front-end assets (`wp_enqueue_scripts`)
- `layout/header`, `layout/sidebar` (only when [`CustomTheme\has_sidebar()`](inc/template-functions.php) returns true), `layout/footer`

SVGs placed in `src/assets/svg/` are compiled into a single sprite (`build/assets/svg/sprite.svg`) via `svg-sprite-loader`. Images in `src/assets/images/` are copied as-is to `build/assets/images/`.

## Gutenberg blocks

Custom blocks live in `src/blocks/<block-name>/` (see `button` and `copyright-date` for examples), each with `block.json`, `edit.js`, `save.js`, `view.js`, `render.php`, and Sass files. `npm run build-block-manifest` generates `src/blocks/blocks-manifest.php`, which is copied to `build/blocks/blocks-manifest.php` and loaded by [inc/blocks.php](inc/blocks.php).

The [`allowed_block_types_all`](functions.php) filter restricts the editor to blocks namespaced under this theme's text domain (`custom-theme/...`) plus WordPress core blocks not filtered out — i.e. third-party block plugins won't appear in the inserter unless added explicitly.

## Styling

Sass is organized using a 7-1-ish pattern under `src/styles/`:

- `abstracts/` — variables, functions, mixins (no CSS output)
- `base/` — typography, icon styles
- `layout/` — grid system
- `utilities/` — helper classes, animations
- `vendors/` — third-party resets (`modern-normalize`)

Entry point: `src/styles/main.scss`, aliased in Webpack as `@styles` for imports elsewhere in `src/`. PostCSS runs Autoprefixer on all compiled CSS (see [postcss.config.js](postcss.config.js)).

## TypeScript

Front-end and admin scripts are written in TypeScript (`strict` mode, ES6 target, ESNext modules). See [tsconfig.json](tsconfig.json) for compiler options; blocks' editor scripts remain plain JS per Gutenberg conventions.

## Theme metadata

See [style.css](style.css) for the theme header (name, version, text domain). Bump `_S_VERSION` in [functions.php](functions.php) on each release — it's used for cache-busting enqueued assets.
