# Financing.ca block theme

Structured after [rtCamp theme-elementary](https://github.com/rtCamp/theme-elementary).
PHP 8.2+, Node 22+, Composer required for development.

## Setup
```
composer install
npm install
npm run build:prod   # or: npm start
```
Zip the theme (including `vendor/` and `assets/build/`, excluding `node_modules/`) to deploy.

## Layout
- `inc/` – PSR-4 `Financing\Theme\` classes. Register new classes in `inc/Main.php` (`Main::CLASSES`).
  - `Core/` Assets, Theme_Setup, Seo, Security_Headers · `Modules/Lead/` REST lead endpoint
- `src/css`, `src/js` – sources; compiled to `assets/build/` (never edit build output).
- `templates/`, `parts/`, `patterns/` – block theme markup. Anchor IDs are used by JS; keep them.
- `tests/` – PHPUnit (`npm run test:php`, needs wp-env) and Jest (`npm run test:js`).

## Notes
- Lead form POSTs to `/wp-json/financing-ca/v1/lead` (emails admin; filter `financing_ca_lead_recipient`).
- Calculator defaults ($12,000 / 180 mo / 9.99% = $129) must stay in sync with hero and section copy.
- Follow-ups: self-host fonts, replace Unsplash hot-links, convert `wp:html` blocks to core blocks.
