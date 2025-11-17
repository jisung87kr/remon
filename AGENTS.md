# Repository Guidelines

## Project Structure & Module Organization
This Laravel 10 app keeps domain logic inside `app/` with dedicated folders such as `app/Livewire` for interactive UI components, `app/Dto` for typed request payloads, `app/Services` and `app/Exports` for business processes, and `app/Policies` for authorization. HTTP entry points live in `routes/web.php` and `routes/api.php`, while UI assets are under `resources/views` (Blade), `resources/js` (Vite modules), and `resources/css`. Translations live in `lang/`. Schema changes belong in `database/migrations` with fixtures in `database/seeders`, and tests live in `tests/Feature` plus `tests/Unit`. Docker definitions (`docker/`, `docker-compose.yml`) exist for parity with production.

## Build, Test, and Development Commands
Run `cp .env.example .env && composer install && npm install` on a new checkout, then `php artisan key:generate`. Serve via `php artisan serve` or `./vendor/bin/sail up`; run `npm run dev` for hot reloads and `npm run build` for production bundles. Keep the database current with `php artisan migrate --seed` so feature tests have data.

## Coding Style & Naming Conventions
Follow PSR-12 with 4-space indentation; `./vendor/bin/pint` enforces formatting before commits. Controllers, jobs, and services use PascalCase suffixed with their role (`OrderReportService`). Livewire classes and Blade views should share the same Studly/Pascal name, e.g., `app/Livewire/ProductTable` ↔ `resources/views/livewire/product-table.blade.php`. Front-end modules are ES modules with named exports, and Tailwind lives in `resources/css/app.css`. Keep language strings snake_case inside `lang/{locale}` arrays.

## Testing Guidelines
Use `php artisan test` (PHPUnit). Favor Feature tests for HTTP flows (`tests/Feature/FooTest.php`) and Unit tests for pure services, naming methods after behaviors (`it_updates_inventory_counts`). When migrations change schema, update seeders so `php artisan test --parallel --processes=4` stays deterministic. Cover Livewire components with browserless checks via `Livewire::test()`.

## Commit & Pull Request Guidelines
Recent history favors short, imperative messages (often in Korean), e.g., `상품명 노출` or `스타일 다듬기`. Keep titles under ~50 characters and explain context in the body if needed. For PRs, include: a concise summary, linked issue or ticket, screenshots/GIFs for UI changes, a checklist of migrations or config updates, and notes on how reviewers can reproduce (`php artisan migrate:fresh --seed`, `npm run dev`).

## Security & Configuration Tips
Secrets stay in `.env`; never commit real keys. Update `APP_URL`, `SANCTUM_STATEFUL_DOMAINS`, and queue/broadcast credentials before running queues (`php artisan queue:work`). After tweaking config, run `php artisan config:cache`, and only clear it with `php artisan config:clear` when debugging.
