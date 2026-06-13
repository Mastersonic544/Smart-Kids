## Bug 1 — Foreign Key Constraint Error on Migrations
- Module: Database / Migrations
- Description: Running `php artisan migrate` failed with "Can't create table `smartkids`.`children` (errno: 150 "Foreign key constraint is incorrectly formed")".
- Steps to reproduce: Run `php artisan migrate` on a fresh database with the initial scaffolded migrations.
- Attempted fixes: Investigated migration order. Discovered `2026_04_20_015444_create_children_table` was running before `2026_04_20_015655_create_classrooms_table`, but the `children` table references `classrooms.id`.
- Resolution: Renamed the classrooms migration to `2026_04_20_015400_create_classrooms_table.php` so it runs before the children migration. Added proper columns to classrooms, children, teachers, and enrollments with French comments per project standards. Dropped all tables and re-ran `php artisan migrate:fresh` successfully.

## Audit 1 — Project Quality & Structural Cleanup
- Module: Multi-module (Controllers, Services, Views, Migrations)
- Description: Performed a comprehensive quality audit to ensure compliance with strict documentation and architectural standards.
- Violations found: Missing Blade context comments in layouts, missing DocBlocks in `ParentDashboardService` and `MealService`, lack of inline column comments in several migrations, and redundant logic in `ParentDashboardController`.
- Resolution: 
    - Added mandatory `{{-- View: ... --}}` headers to all layouts and core views.
    - Standardized DocBlocks across ALL services.
    - Enforced inline SQL comments on all custom migration columns.
    - Refactored `ParentDashboardController` to move aggregation logic to its Service.
    - Deleted unused placeholder controllers (`AttendanceController`, `ChildController`, `PaymentController`) to prevent routing confusion.
- Date resolved: 2026-04-20

## Bug 2 — Internal Server Error: Column not found 'classrooms.educator_id'
- Module: Admin/Teacher Management
- Description: Encountered `Illuminate\Database\QueryException`: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'classrooms.educator_id' in 'where clause' when navigating to `/admin/teachers`.
- Steps to reproduce: Browse to the `/admin/teachers` page as an admin after adding the `educator_id` to `classrooms` relationship definition in Models.
- Attempted fixes: Investigated `Classroom` and `Teacher` models to ensure `educator_id` was correctly configured as the foreign key for the relations. Then inspected database schema to confirm if the column existed.
- Resolution: Found that the migration `2026_04_29_100000_add_educator_id_to_classrooms_table` was created but not executed (`php artisan migrate:status` showed it as Pending). Ran `php artisan migrate` to execute the pending migration. This successfully created the `educator_id` column and resolved the eager loading error.
- Date resolved: 2026-05-23

## Bug 3 — Internal Server Error: RelationNotFoundException on Activity
- Module: Admin/Activity Management
- Description: Encountered `Illuminate\Database\Eloquent\RelationNotFoundException`: Call to undefined relationship [educator] on model [App\Models\Activity] when accessing `/admin/activities`.
- Steps to reproduce: Browse to `/admin/activities` as an admin. The controller queries `Activity::with('educator')`.
- Attempted fixes: Investigated `Activity` model and found the relationship was named `teacher()` instead of `educator()`. Searched the views to verify which names they expect. Views called `$activity->educator->nom`.
- Resolution: Renamed the relation method from `teacher()` to `educator()` in `app/Models/Activity.php` to match the expected eager loading call in the repository and the object references in the views.
- Date resolved: 2026-05-23

## Bug 4 — Hamburger Menu unresponsive on Welcome Page
- Module: Marketing / Landing Page
- Description: The mobile hamburger navigation menu on `welcome.blade.php` did not work when clicked.
- Steps to reproduce: Open homepage on a mobile-sized viewport and press the hamburger button.
- Attempted fixes: Investigated `welcome.blade.php` and found there was only a placeholder button with no toggle logic or dropdown menu built out. 
- Resolution: Implemented Alpine.js `x-data="{ open: false }"` state on the `<nav>`, updated the SVG icons to switch between hamburger/close states on click, and added a responsive dropdown container with links to features and auth portals.
- Date resolved: 2026-05-23

## Bug 5 — Uncaught SyntaxError (Unexpected token '<') in Messaging Polling
- Module: Messaging / Real-Time Polling
- Description: Encountered recurring `Uncaught (in promise) SyntaxError: Unexpected token '<', "<!DOCTYPE "... is not valid JSON` in the browser console while on the conversation page.
- Steps to reproduce: Open a direct message conversation page. If the session expires or if the server redirects a GET request due to auth middleware, the `fetch` API receives a 302 Redirect to `/login`, which resolves as an HTML 200 response rather than JSON.
- Attempted fixes: Investigated `laravel.log` and found no associated PHP Exceptions, proving the request was hitting an external redirect rather than a server error. Inspected `fetch` logic in `conversation.blade.php`.
- Resolution: Updated the AJAX polling headers to explicitly include `'X-Requested-With': 'XMLHttpRequest'`. This forces Laravel's auth middleware to intercept unauthorized requests and return a `401 Unauthorized` JSON format instead of an intrusive HTML redirect sequence. Additionally, added `.ok` and `content-type` safety checks inside `.then()` and caught the promise using `.catch(error => console.warn(error))` to ensure polling can gracefully fail without spamming the console with `SyntaxError`s.
- Date resolved: 2026-05-23

## Bug 6 — LaTeX Compilation Failures & Undefined Packages/Images
- Module: Documentation / LaTeX Report
- Description: Compiling `main.tex` failed with multiple errors, including undefined `float` option `[H]`, undefined `tikzpicture` environment, invalid UTF-8 byte sequences in code listings/verbatim, and missing screenshots/logos in `images/`.
- Steps to reproduce: Run `pdflatex main.tex` in `latex-report/`.
- Attempted fixes: Investigated `main.tex` preamble, file dependencies, and character encodings of source `.tex` files.
- Resolution:
  1. Uncommented `\usepackage{float}` in `main.tex` to allow `[H]`.
  2. Added `\usepackage{tikz}` in `main.tex` to support block diagrams.
  3. Replaced unicode drawing characters in `05-architecture.tex` verbatim block with ASCII character trees.
  4. Removed accented characters (`é`, `à`, `è`, `°`) from code blocks in listings to prevent compilation crashes on UTF-8 characters under pdflatex.
  5. Changed listings language settings from `JavaScript` and `JSON` to empty braces (`language={}`) since listings doesn't support them natively.
  6. Mapped and copied existing screenshots from `latex rapport pfe/images/` to `latex-report/images/` and generated a professional `logo.png` via DALL-E/Imagen to replace the missing branding graphic.
- Date resolved: 2026-06-07
