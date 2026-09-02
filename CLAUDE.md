# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this project is

A Laravel 12 + Livewire/Volt CRUD sample for a single `Person` model (`name`, `age`), built on the official Laravel/Livewire starter kit (Fortify auth, Flux UI free components, Tailwind v4). Requires PHP 8.2+ (CI runs 8.4, local Herd env runs 8.5).

## Commands

Install/setup:
```
composer install
npm install
```

Dev servers (serve + queue + logs + vite, all concurrently):
```
composer run dev
```

Build frontend assets:
```
npm run build
```

Lint/format (must be run before finalizing PHP changes — CI enforces this via `vendor/bin/pint` with no `--dirty`/`--test`, so an unformatted diff fails linting):
```
vendor/bin/pint --dirty --format agent
```

Tests (Pest 4):
```
php artisan test --compact                              # full suite
php artisan test --compact tests/Feature/PersonCrudTest.php   # one file
php artisan test --compact --filter=testName             # by name
./vendor/bin/pest --type-coverage                        # type coverage (see README "Update Rules")
./vendor/bin/pest --update-snapshots                      # regenerate view snapshots after intentional markup changes
```
Run the minimal, targeted set of tests for a change; ask before running the full suite.

## Architecture

- **UI layer is Livewire Volt/class components, not controllers.** There is no CRUD controller — `routes/web.php` maps URLs directly to Livewire components via `Volt::route(...)`, and the components (`app/Livewire/PeopleIndex.php`, `app/Livewire/PersonShow.php`) hold both the state/logic and (via `render()`) point to their Blade view in `resources/views/livewire/`. When changing behavior for a page, edit the Livewire component class, not a controller.
- **Single form component handles add + edit.** `PersonShow::mount()` inspects the route-model-bound `Person` (route is `person/{person?}`) — if it has no id, `method` is set to `add`; otherwise to `update`. The Blade view branches its submit action on `$method`. Keep this dual-purpose pattern in mind when touching `person-show`.
- **Volt is mounted from two view paths**: `resources/views/livewire` and `resources/views/pages` (see `app/Providers/VoltServiceProvider.php`), but only `livewire/` is currently used.
- **`Person` uses `SoftDeletes`** — deleted records are not physically removed; queries needing trashed records must opt in explicitly.
- Auth scaffolding (Fortify actions, settings pages, two-factor) came from the starter kit and is largely unmodified; the actual "sample" logic is the `Person` CRUD (`app/Models/Person.php`, `app/Livewire/PeopleIndex.php`, `app/Livewire/PersonShow.php`, `routes/web.php` people/person routes, `database/migrations/2026_01_11_061047_create_people_table.php`, `database/factories/PersonFactory.php`).

## Testing conventions

- Feature tests use Pest's browser testing (`visit()`, Pest v4 `pestphp/pest-plugin-browser`) to exercise the Livewire pages end-to-end (fill fields, click buttons, assert visible text) — see `tests/Feature/PersonCrudTest.php`. `RefreshDatabase` is bound to all Feature tests via `tests/Pest.php`.
- `tests/Feature/PersonViewSnapshotTest.php` snapshot-tests the raw rendered HTML of the `person-show` page. The `toMatchSnapshot` pipe in `tests/Pest.php` normalizes volatile output (CSRF token, `wire:id`, `wire:snapshot`, `data-csrf`) before comparing — do not hand-edit snapshot files; regenerate with `./vendor/bin/pest --update-snapshots` when a markup change is intentional, and review the diff.
- Test DB is in-memory SQLite (`phpunit.xml`); mail/queue/broadcast/session are faked/synced for speed.

## Laravel Boost / project conventions (from `.github/copilot-instructions.md`, mirrored in `.junie/guidelines.md`)

These are the maintained project guidelines; the summary below covers what's most load-bearing for this repo (the full text has more Laravel/Livewire/Pest boilerplate detail):

- Follow existing conventions in sibling files before introducing a new pattern; don't create new base directories or add dependencies without approval.
- PHP: constructor property promotion, explicit return types on all methods/functions, curly braces even for one-line control structures, PHPDoc over inline comments.
- Prefer Eloquent (`Model::query()`) over raw `DB::`; eager-load to avoid N+1.
- Validation belongs in Form Request classes, not inline in controllers (note: this codebase currently validates via Livewire's `#[Validate]` attribute directly on component properties instead, since there are no controllers involved — follow that existing pattern for Livewire components).
- Use named routes + `route()` for links; never call `env()` outside config files — use `config(...)`.
- New interactive pages should use Livewire Volt; check whether an existing Volt component is functional or class-based before adding to it (this repo's are class-based `Component` subclasses driven by separate view files, not single-file `@volt` components).
- A **Laravel Boost MCP server** is configured (`.mcp.json`, `.junie/mcp/mcp.json`) exposing tools like `search-docs`, `tinker`, `database-query`, `browser-logs`, `list-artisan-commands` — prefer `search-docs` over guessing at Laravel/Livewire/Flux/Pest API details, and prefer `tinker`/`database-query` over ad-hoc verification scripts.
- Don't create documentation files unless explicitly requested.
