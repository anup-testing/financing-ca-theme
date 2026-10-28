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
  - `templates/front-page.html` (header-home part): home-hero → home-ticker → home-showcase → home-features →
    home-hard-water → home-why-switch → home-swap → home-cta. Built from core blocks (group, columns, heading,
    paragraph, image, buttons) so every word, image and button is editable in the Site Editor.
  - `templates/page-about.html` ("About Page" template): page-hero → marquee → story → mission → advantages →
    installation → testimonials. Card grids in these patterns are still `wp:html`.
  - Button block styles `light` and `text` are registered in `Core/Theme_Setup`.

## Pages the theme links to
Create these pages in WordPress so header/footer links resolve: `about-us`, `faqs`, `blog` (posts page),
`contact-us`, `privacy-policy`, `terms-and-conditions`.

## Notes
- Footer email form POSTs to `/wp-json/the-tankless/v1/lead` (emails admin; filter `tankless_lead_recipient`).
  Only `email` is required; `name`, `phone`, `city`, `message`, `source` are optional for future contact forms.
- `assets/images/*.svg` are placeholders (product, storage tank, Ontario coverage map) — swap in real photos via the Image blocks.
