# SmartKids — Session Handoff

End of report-polishing session.  Next session = SmartKids **code** only
(improve, test, capture screenshots).  Report work resumes after that.

Date: 2026-06-13.

---

## 1. Where the report stands right now

- **Source**: `latex-report/main.tex`, compiles clean with `xelatex` (two passes).
- **Last successful build**: 80 pages, 0 errors, 0 fatal warnings.
- **Compiler chain**: `xelatex → xelatex` (bibtex skipped, bibliography is
  currently empty by design — see §5 below).
- **Chapter list**:
  1. Introduction (frozen — do not touch)
  2. General Project Framework (Mega Pixel + project context + Aya-style)
  3. Sprint 0 — Specification of Needs (Scrum, backlog, env)
  4. Sprint 1 — Administrator module
  5. Sprint 2 — Educator module
  6. Sprint 3 — Parent module
  7. General Conclusion
- **Bibliography input**: `references.bib` exists, citations stripped during
  the fabricated-content audit. `\printbibliography` still in `main.tex` —
  triggers the "Empty bibliography" warning every build.

## 2. Things already polished

| Area                      | Done                                                                 |
|---------------------------|----------------------------------------------------------------------|
| Structure (Aya alignment) | All sprint chapters follow Aya Aroui's pattern                       |
| Fabricated content        | Removed (personas, survey, Sprint 4/5 metrics, marketing projections) |
| Chapter title pages       | Custom `\@makechapterhead` — number + name + double rule decorations |
| UC diagrams               | Sprint backlog UCs + 14 raffinement UCs                              |
| UC actor positions        | Forced left side (`linetype polyline`, anchors removed)              |
| UC `<<include>>` arrows   | Direction base→included                                              |
| UC `<<extend>>` arrows    | Direction extension→base (opposite to include)                       |
| UC `Manage Educators/Classrooms` | **Split** into two separate diagrams                          |
| UC `Manage Payments`      | **Split** into Record Payment + Track Overdue Payments               |
| UC diagram sizing         | Aspect-ratio-based widths (very wide → `\textwidth`)                 |
| Software environment §3.9 | All tools have a logo (PHP, MySQL, Tailwind, Composer, Vite, DomPDF, PlantUML, Mermaid, Postman, Netlify, Supabase, VS Code, GitHub, Laravel) |
| Deployment section        | Netlify + Supabase wired, no fake Trello screenshot                  |
| Global UC                 | Rebuilt in StarUML (new layout with extends), PNG dropped in         |
| Class diagrams            | One slice per sprint (sprint1 / sprint2 / sprint3)                   |
| Sequence diagrams         | 13 sequence diagrams, all clean                                      |

## 3. Things still open on the report side

### 3.1 In-progress at session pause

- **Bendy UC arrows audit** — finished restructuring `uc_admin_dashboard`,
  `uc_parent_dashboard`, `uc_educator_class_list`, `uc_parent_payments` so
  the base UC sits leftmost in the rectangle and the actor connects with a
  straight diagonal.  *Not yet visually re-verified after the last edit.*
  Next time, open these four PNGs and confirm:
  - actor sits on the left side, vertically centered with the base UC
  - all `Admin --` / `E --` / `P --` lines are straight
  - extend arrows go from the extension UC (now on the right of base) back
    to the base, opposite direction to include arrows.

### 3.2 Empty bibliography

`main.tex` line ~262 still calls `\printbibliography`.  Either:

- repopulate `references.bib` with real, citable entries (Laravel docs,
  Scrum guide, OWASP top 10, MySQL docs, etc.) and add `\cite{...}` in the
  chapter prose where the references actually justify the choices, **or**
- comment out `\printbibliography` to drop the empty bibliography from the
  PDF (and remove the warning).

### 3.3 Unused screenshots already on disk

Sitting in `latex-report/images/` but never `\includegraphics{}`ed:

- `login.png` — login screen (Sprint 1 §Graphical Interfaces would slot it)
- `child-profile.png` — child profile detail (Sprint 1, next to children-list)
- `messaging.png` — messaging UI (Sprint 3, next to notification-parent)
- `payment-history.png` — payment history view (Sprint 3, next to payment-receipt)
- `landing-page.png`, `logo.png`, `admin space activities.png`,
  `notification to parent.png` (older copy), `payment receipt.png` (older copy)

The first four are useful — wire them in after the new screenshot pass.

### 3.4 Leftover files / duplicates safe to delete

- Folder `latex-report/new data/` (with the space — older iteration)
- `latex-report/new_data/isb-logo.png` (duplicate of `images/isb logo transparent bg.png`)
- `latex-report/new_data/mega_pixel_ab_logo.jfif` (duplicate of `mega-pixel-logo.jpg`)
- All `latex-report/_*.log`, `latex-report/c?.log`, `latex-report/cb.log`,
  `latex-report/compile?.log` — stale compile logs.

Don't delete without a quick `grep` against the chapter files first.

## 4. Global use case — StarUML workspace

Folder `latex-report/global uc staruml/` contains:

| File                          | Purpose                                                |
|-------------------------------|--------------------------------------------------------|
| `smartkids_global_uc.mdj`     | Ready-to-open StarUML project                          |
| `build_mdj.py`                | Generates the `.mdj`. Edit layout/extends here.        |
| `01_build_diagram.js`         | DevTools console — builds the diagram from scratch     |
| `02_add_extends.js`           | DevTools console — patches in only the 4 extends       |
| `Global Use Case.jpg`         | Hand-laid-out export from StarUML                      |
| `DEVTOOLS_GUIDE.md`           | Full guide                                             |

`Global Use Case.jpg` has already been converted to PNG and dropped at
`umls/img/usecase_global_en.png`, and the report is using it.

## 5. Code-improvement session — what to focus on next

The user explicitly asked for a session dedicated to **code improvements**,
followed by **tests**, then **screenshots**.  Suggested order:

### 5.1 Code health pass

Walk every controller / service / repository in the Laravel backend and:

- Check the Service-Repository separation isn't being violated (controllers
  going straight to Eloquent, services owning HTTP concerns, etc.).
- Tighten validation: every form request should be a `FormRequest` subclass,
  no controller-level inline validation.
- Make sure policies / gates wrap every parent-side route (`ParentScopeFilter`
  must be the single source of truth for `child_id` allowlists).
- Confirm `ChildPolicy`, `PaymentPolicy`, `MessagePolicy` exist and are wired
  into the routes via `->middleware('can:...')`.
- Audit the receipt PDF generation path for race conditions — DomPDF + the
  queued job pattern must agree on the `receipt_url` write timing.
- Hunt down any `dd()`, `var_dump()`, `Log::debug()`, `console.log` leftovers.
- Run `composer require laravel/pint --dev` then `vendor/bin/pint` and commit
  the formatting pass separately.

### 5.2 Security hardening before screenshots

- CSRF tokens present on every POST form (Blade `@csrf`).
- Rate limit `/login`, `/messages/store`, `/password/reset`.
- `bcrypt` (or argon2id) password hashing confirmed in `User::password`.
- `notifications` polling endpoint must be auth-gated and return only the
  current user's rows.
- Storage bucket: `dossiers/`, `receipts/`, `child-photos/` should reject
  direct public reads — only the secured download controller serves them.

### 5.3 Tests

Minimum set to write so screenshots feel earned:

- Feature test: admin can create a child, photo gets resized + stored,
  receipt PDF can be regenerated.
- Feature test: educator can mark attendance, parent receives a notification
  row in `notifications`.
- Feature test: parent **cannot** request another family's child (`/child/{X}`
  returns 403).
- Feature test: messaging recipient list excludes other parents.
- Unit test: `ParentScopeFilter` returns the exact `child_id` set for a parent.
- Browser test (Dusk) covering the golden parent flow:
  login → dashboard → payment history → download receipt PDF.

### 5.4 Screenshot capture pass

After the code and tests are green, re-capture the UI for the report.
Required shots (all 1280×800 or similar, taken in a clean session with seed
data — no debug toolbars, no console errors):

| Sprint | Screen                                | Filename (drop in `latex-report/images/`)   |
|--------|---------------------------------------|---------------------------------------------|
| 1      | Login                                 | `login.png` (overwrite existing)            |
| 1      | Admin dashboard                       | `admin-dashboard.png` (overwrite)           |
| 1      | Children list                         | `children-list.png` (overwrite)             |
| 1      | Child profile detail                  | `child-profile.png` (overwrite)             |
| 1      | Payment receipt PDF rendered          | `payment-receipt.png` (overwrite)           |
| 2      | Educator dashboard                    | `teacher-dashboard.png` (overwrite)         |
| 2      | Daily attendance grid                 | `attendance.png` (overwrite)                |
| 2      | Activities create form                | `activities.png` (overwrite)                |
| 3      | Parent dashboard                      | `parent-dashboard.png` (overwrite)          |
| 3      | Weekly menu                           | `menu.png` (overwrite)                      |
| 3      | Payment history (NEW — wire in)       | `payment-history.png`                       |
| 3      | Messaging conversation (NEW)          | `messaging.png` (overwrite)                 |
| 3      | Notification feed                     | `notification-parent.png` (overwrite)       |

After the new screenshots land, come back to the report side to:

1. Wire `login.png`, `child-profile.png`, `payment-history.png`,
   `messaging.png` into their sections (see §3.3).
2. Re-verify the bendy-arrow fix from §3.1.
3. Decide on the bibliography (§3.2).
4. Final `xelatex × 2` and confirm page count.

## 6. Open questions for the user

These weren't answered before pause, flag them at the next report session:

1. Bibliography: repopulate or remove `\printbibliography`?
2. VS Code logo currently shows the parent **Microsoft** mark (since it was
   pulled from the `microsoft` GitHub org avatar). Want to swap for the
   dedicated blue VS Code logo?
3. Vite logo shows the Vitest-style mark (also pulled from `vitejs` GitHub
   org avatar). Want the classic yellow lightning bolt instead?
4. Delete the `new data/` folder?
