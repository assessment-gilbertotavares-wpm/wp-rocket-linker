# WP Rocket Linker

Capture and analyze which homepage links are visible above the fold over the past 7 days. Data is recorded via REST API and displayed in the admin dashboard.

## Requirements

- PHP >= 7.3
- WordPress >= 6.0
- MySQL
- Composer
- Node.js + npm
---

## Installation

Clone the repository:

```bash
git clone https://github.com/assessment-gilbertotavares-wpm/wp-rocket-linker.git
cd wp-rocket-linker
````

Install PHP dependencies with Composer:

```bash
composer install
```

Install JavaScript dependencies with npm:

```bash
npm install
```

Build the frontend assets:

```bash
npm run build
```

---

## Usage

1. Activate the plugin in your WordPress admin.
2. Visit your homepage as a visitor (in a browser).
3. After 1 second, the plugin collects links visible above the fold and sends them to the backend via REST API.
4. To view collected data:

   * Go to **Linker Entries** menu in the WordPress admin dashboard.
   * Visible links, screen size, and timestamp will be displayed.

---

## Development

### JavaScript development

Start the development watcher and compiler:

```bash
npm run start
```

Run JS linting:

```bash
npm run lint:js
```

Format code:

```bash
npm run format
```

---

## Project structure

* `wp-rocket-linker.php` — Main plugin file
* `src/` — PHP implementation organized by feature (Admin, REST API, Database)
* `assets/js-src/` — Modern JS source code (ES Modules)
* `assets/js/` — Compiled JS assets
* `bin/install-wp-tests.sh` — Script to install WordPress testing suite
* `composer.json` — PHP dependencies and scripts
* `package.json` — JS dependencies and scripts
* `.editorconfig`, `.gitattributes`, `.gitignore`, `phpcs.xml`, `.eslintignore`, `.prettierignore` — Coding standards configuration

---

## Automatic cleanup

The plugin automatically deletes entries older than 7 days via a scheduled daily event (`wp_rocket_linker_cleanup_daily`).

---

## License

GPLv2 or later. See [LICENSE](./LICENSE) for details.
