# The Tankless block theme

Dark block theme for The Tankless (thetankless.ca), structured after [rtCamp theme-elementary](https://github.com/rtCamp/theme-elementary).
PHP 8.2+, Node 22+, Composer required for development.

## Setup
```
composer install
npm install
npm run build:prod   # or: npm start
```
Zip the theme (including `vendor/` and `assets/build/`, excluding `node_modules/`) to deploy.

## Layout
- `inc/` – PSR-4 `Tankless\Theme\` classes. Register new classes in `inc/Main.php` (`Main::CLASSES`).
  - `Core/` Assets, Theme_Setup, Seo, Security_Headers · `Modules/Lead/` REST lead endpoint
- `src/css`, `src/js` – sources; compiled to `assets/build/` (never edit build output).
- `templates/`, `parts/`, `patterns/` – block theme markup. `#leadform`, `#formnote`, `#nav` are used by JS; keep them.
  - `templates/page-about.html` (also selectable as the "About Page" template) and `templates/front-page.html`
    render: page-hero → marquee → story → mission → advantages → installation → testimonials.

## Pages the theme links to
Create these pages in WordPress so header/footer links resolve: `about-us`, `faqs`, `blog` (posts page),
`contact-us`, `privacy-policy`, `terms-and-conditions`.

## Notes
- Footer email form POSTs to `/wp-json/the-tankless/v1/lead` (emails admin; filter `tankless_lead_recipient`).
  Only `email` is required; `name`, `phone`, `city`, `message`, `source` are optional for future contact forms.
- `assets/images/tankless-unit.svg` is a placeholder illustration — swap in the real product photo.
- The front page currently reuses the About layout; replace with a dedicated home layout when its design is ready.
