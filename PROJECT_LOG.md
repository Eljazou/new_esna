# PROJECT_LOG — esna-new (CRM VMP / Metronic rebuild)

> **Single source of truth.** Any session resuming this work should read this file first.
> Update it at the end of *every* step, not just at the end of the whole task.

---

## 1. Project summary

**What esna-new is:** a visual rebuild of the legacy `esna` application (an internal
pharmaceutical-sales CRM, UI language = **French**, titled *"CRM VMP"*). The PHP
application logic is carried over as-is; only the presentation layer is rebuilt on the
Metronic 8 design system.

**Goal of the migration:** 100% Metronic (Bootstrap 5) look across the entire app, with
**zero AdminLTE / Bootstrap 3 remnants**. Business logic, controller variables, form
actions and security fields are preserved untouched — only classes, wrapper markup and
asset includes change.

### Stack

| Item | Version / value | Notes |
|---|---|---|
| Framework | **CakePHP 2.10.19** | from `lib/Cake/VERSION.txt`; classic `app/` + `lib/` layout, `.ctp` views |
| PHP target | **5.6 – 7.4** | CakePHP 2.10 supports PHP >= 5.3; 7.4 is the practical ceiling (Cake 2.x is not PHP 8 clean) |
| Design system | **Metronic 8.2.0**, Demo 1, HTML/dist build | Bootstrap 5, author Keenthemes |
| Icon system | **Keenicons** (`ki-duotone` dominant) | verified by scanning Metronic HTML — see §5 |
| Legacy UI being replaced | **AdminLTE 2 / Bootstrap 3** | `.box`, `.small-box`, `.info-box`, `bg-aqua`, Ionicons, Font Awesome 4 |
| Fonts | Inter (Metronic default), Poppins (used by current layout) | both loaded from Google Fonts CDN |

### Repository layout (read-only vs writable)

```
metronic-rebuild/
├── Metronic/    ← design system source        — READ ONLY, never modify
├── esna/        ← legacy CakePHP 2.10 app     — READ ONLY, reference for "what should this page do"
└── esna-new/    ← THIS repo (fresh git init)  — all new work happens here
```

---

## 2. Functionalities inventory

The app is a **CRM for pharmaceutical medical representatives** (*visiteurs médicaux*).
Reps visit doctors/pharmacies/hospitals, log visits and reports, distribute samples and
promotional items, file expense claims, and are measured against objectives. Derived from
`esna/app/Controller/` (65 controllers), `app/Model/` (75 models) and the sidebar menu in
`app/View/Layouts/default.ctp`.

### Core domain modules

| Module | Controllers | What it does |
|---|---|---|
| **Visits / field activity** | `Visites`, `Visiteordres`, `Stockvisites`, `Plantournes` | Core loop: plan tours, record visits to clients, visit ordering, per-visit sample stock |
| **Clients / customers** | `Clients`, `Clientspropose`, `Hopitals`, `Grosistes`, `Prospects` | Doctor / pharmacy / hospital / wholesaler records, client proposals, prospect pipeline |
| **Reporting** | `Rapports`, `Actionrapports`, `Rapportprocpects`, `Analyses`, `Statistiques` | Activity reports, action reports, prospect reports, performance analysis dashboards |
| **Samples & giveaways** | `Echantillons`, `Autoechantiants`, `Gadjets`, `Gadgetclients`, `Brochures` | Sample stock in/out, self-declared samples, promotional gadgets, brochure distribution |
| **Expenses** | `Notefrais`, `Notefraissecteurs`, `Notevalidations`, `Avences` | Expense claims per rep/sector, validation workflow, cash advances |
| **Objectives & evaluation** | `Objectifs`, `Objectifprofiles`, `Odpobjectifs`, `Evaluations` | Sales/visit targets by profile & sector, periodic rep evaluation |
| **Products & catalogue** | `Produits`, `Groproduits`, `Packs`, `Offres`, `Categories`, `Types`, `Lignes` | Product catalogue, wholesaler products, packs, special offers, categories, product lines |
| **Orders & sales** | `Commandes`, `Groventes` | Client orders, wholesaler sales |
| **HR / absence** | `Absences`, `Jourferiers`, `Formations` | Absence calendar, public holidays, training sessions |
| **Users & access** | `Users`, `Droits`, `Secteurs`, `Asm` | Users/reps, per-controller-action rights (`Droits::getrole`), sector assignment, ASM (area manager) views |
| **Marketing / digital** | `Marketings`, `Digitals`, `Prospectcompagnes`, `Prospectaffaires` | Marketing actions, digital/telemarketing centre, campaigns, deals |
| **Communication** | `Boitemails`, `Boiteidees`, `Notifications`, `Emails` | Internal mailbox, idea box, notifications |
| **Documents & misc** | `Documents`, `Listes`, `Services`, `Games`, `Zquestions`, `Evaluations` | Document library, listings ("Mon listing", feuille de route), services, gamification, questionnaires |
| **Mobile / API** | `Apimobile`, `Apimobilev1`, `Visitemobileapis`, `Appweb`, `Appwebfinal`, `Appwebfinalv2` | JSON APIs for the mobile app + web app variants |
| **AI services** | `Iaservices` | AI-assisted features (newer addition) |

### Cross-cutting mechanisms (must not be broken by restyling)

- **Auth**: `AuthComponent` with `authorize = 'Controller'`; `AppController::isAuthorized()`
  gates every action. Login errors are French strings.
- **Rights**: views call `$this->requestAction('/droits/getrole/<controller>/<action>')`
  inline to show/hide buttons — **94 view files** rely on this. These calls must be
  preserved verbatim when restyling.
- **Flash messages**: `$this->Session->setFlash(...)`, rendered by the layout.
- **Layouts**: `default.ctp` (back-office), `appmobile*.ctp` / `mobile.ctp` (mobile web),
  `ajax.ctp`, `blanck.ctp`, `login.ctp`, `error.ctp`, `flash.ctp`.

---

## 3. Migration status

Legend: ✅ done · 🟡 in progress · ⬜ pending · ⛔ blocked

### Bootstrap phase

| # | Task | Status |
|---|---|---|
| 0 | Create `PROJECT_LOG.md` | ✅ 2026-07-21 |
| 1 | Clone `Metronic/` + `esna/` references | ✅ 2026-07-21 |
| 2 | Copy full esna CakePHP app into `esna-new/` | ✅ 2026-07-21 |
| 3 | Copy Metronic `assets/` (css, js, plugins, media) into `app/webroot/` | ✅ 2026-07-21 |
| 4 | Identify Metronic's real icon system | ✅ 2026-07-21 — **Keenicons** |
| 5 | `git init` fresh repo in `esna-new/` | ✅ 2026-07-21 |
| 6 | Inventory of all `.ctp` by legacy pattern | ✅ 2026-07-21 — see §5 |
| 6b | Audit inherited `default.ctp` + Metronic bundle contents | ✅ 2026-07-21 — see §4 |
| 7 | Master layout `default.ctp` via `Html->css()` / `Html->script()` | ✅ 2026-07-22 |
| 7b | Classify mobile/API view groups (in scope vs out) | ✅ 2026-07-22 — **in scope**, see §7 |
| 8 | Shared partials (sidebar / topbar / flash / breadcrumbs) | ✅ 2026-07-22 |
| 8b | Delete dead `_old.ctp` files (16) | ✅ 2026-07-22 |
| 9 | Page-by-page reconstruction — **Clients (15 views)** | ✅ 2026-07-22 |
| 10 | Page-by-page — **Visites (13 views)** | ✅ 2026-07-23 |
| 11 | Page-by-page — **Rapports (11 views)** | ✅ 2026-07-23 |
| 12 | Page-by-page — **Users (15 views)** | ✅ 2026-07-23 |
| 13 | Page-by-page — **Listes (12 views)** | ✅ 2026-07-23 |
| 14 | Next: remaining ~40 small CRUD modules + mobile groups | ⬜ |

### Per-module migration checklist

See §5 (inventory) — every module row becomes ✅ as its views are rebuilt.

**Done (29 modules, 202 views):** Clients 15, Visites 13, Rapports 11, Users 15,
Listes 12, Prospects 8, Brochures 8, Rapportprocpects 6, Analyses 7,
Prospectcompagnes 6, Grosistes 6, Evaluations 6, Echantillons 6, Documents 6,
Commandes 6, Avences 6, Secteurs 5, Produits 5, Packs 5, Offres 5,
Objectifprofiles 5, Notefrais 5, Groproduits 5, Games 5, Gadjets 5,
Formations 5, Clientsproposes 5, Categories 5, Actions 5.

Plus the 4-view tier (batch 3): Zquestions, Types, Prospectaffaires, Pots,
Odpobjectifs, Objectifs, Marketings, Lignes, Jourferiers, Groventes, Digitals,
Autoechantiants, Absences — 4 views each. **42 modules, 254 views done.**

Plus the ≤3-view tail (batch 4): Statistiques 3, Notevalidations 3,
Notefraissecteurs 3, Hopitals 3, Boitemails 3, Boiteidees 3, Actionrapports 3,
Stockvisites 2, Droits 2, Asm 2, Services 1, Plantournes 1, Pages 1,
Notifications 1, Gadgetclients 1.

### ✅ Desktop CRUD track complete — 57 modules, 286 views

**Still outstanding:** the mobile/web-app track (§7 — `Appweb` 10,
`Appwebfinal` 13, `Appwebfinalv2` 14, `Visitemobileapis` 4 = 41 views), the
`Elements/` directory, and the remaining layouts (`appmobile`, `appmobilepro`,
`mobile`, `error`, `blanck`, `Emails/`, `Errors/`). The mobile views sit on
**Bootstrap 4.3.1 / AdminLTE** layouts — a BS4→BS5 job, distinct from the
BS3→BS5 work done so far, and they need their own layout decisions first.

**Separate track (§7):** `Appweb` 10, `Appwebfinal` 13, `Appwebfinalv2` 14,
`Visitemobileapis` 4 — Bootstrap 4.3.1/AdminLTE layouts, a BS4→BS5 job distinct
from the desktop BS3→BS5 work. Also outstanding: `Elements/`, the remaining
layouts (`appmobile`, `appmobilepro`, `mobile`, `error`, `blanck`, `Emails/`).

---

## 4. Changes log

### 2026-07-21 — Step 0/1: bootstrap

- **Created** `metronic-rebuild/` with `Metronic/` (shallow clone of
  `AbdelhamidSmiri/metronic_demo1`) and `esna/` (shallow clone of `its-me-karima/esna_AI`).
  Both are reference-only and are never written to.
- **Created** `esna-new/` and copied from `esna/`: `app/`, `lib/`, `plugins/`, `index.php`,
  `.htaccess`, `.gitignore`, `build.properties`, `build.xml`. All controllers, models and
  376 `.ctp` views are preserved as the starting point.
- **Copied** `Metronic/demo1/dist/assets/` → `esna-new/app/webroot/metronic/demo1/dist/assets/`
  (css 1.3M, js 953K, media 47M, plugins 24M).
  - **Decision — why that exact path:** the legacy `default.ctp` *already* references
    `/metronic/demo1/dist/assets/...`, but `esna/app/webroot/metronic/` was shipped **empty**
    (assets were never committed to the old repo). Mirroring Metronic's own
    `demo1/dist/assets` structure both (a) satisfies the existing references and (b) keeps
    Metronic's internal relative URLs intact — verified: `plugins.bundle.css` requests
    `url(fonts/keenicons/keenicons-duotone.woff)`, which resolves to
    `assets/plugins/global/fonts/keenicons/` ✓.
- **`git init`** in `esna-new/` (fresh history, not a fork of the old repo).
- **Verified** icon system: scanning every `.html` in `Metronic/demo1/dist` gives
  `ki-duotone` 36,069 · `ki-outline` 444 · `ki-solid` 130 · `fa` 52 · `bi` 44.
  → Metronic uses **Keenicons**; Font Awesome/Bootstrap Icons appear only incidentally.
  Font files live at `assets/plugins/global/fonts/keenicons/` and are loaded by
  `plugins.bundle.css` (no separate stylesheet needed).
- **Discovered** the legacy `default.ctp` (1,384 lines) had *already* been partially
  converted to Metronic markup (`kt_app_header`, `app-sidebar`, `ki-duotone`, 41 matches)
  with a large inline `<style>` block of custom purple theming (`--lb-primary: #7c6ff0`)
  and Poppins as the body font. **No AdminLTE markers remain in the layout itself** — the
  remaining legacy debt is almost entirely in the individual page views.

### 2026-07-21 — Step 1: audit of inherited `default.ctp` (no edits yet)

Structure map (line numbers refer to the copied `app/View/Layouts/default.ctp`):

| Lines | Section |
|---|---|
| 11–14 | Metronic CSS + `plugins.bundle.js` in `<head>` |
| 17–24 | CDN: Google Fonts (Poppins), flatpickr CSS, **Font Awesome 4** |
| 25–231 | ~206-line inline `<style>` — custom purple theme, sidebar-minimize logic |
| 234–236 | `<body id="kt_app_body">` + `data-kt-app-*` layout flags |
| 239 | `jquery-2.2.3.min` loaded from local webroot |
| 246–323 | Header / topbar (notifications, mailbox, user menu, logout) |
| 324–1071 | **Sidebar menu — ~750 lines**, hard-coded, with `Droits` rights checks inline |
| 1072–1083 | `app-main` → `$this->Session->flash()` + `$this->fetch('content')` |
| 1084–1095 | Footer (ESNAPHARM, CRM VMP) |
| 1097–1139 | Floating "Chat with IA" button + Bootstrap 5 modal |
| 1145–1149 | `plugins.bundle.js`, `scripts.bundle.js`, flatpickr CDN |

Metronic bundle contents verified by scanning the copied files:
- `plugins.bundle.js` **already contains jQuery, Select2, flatpickr and daterangepicker**.
- **DataTables is not** in the global bundle — it ships separately as
  `assets/plugins/custom/datatables/datatables.bundle.{css,js}` (Bootstrap 5 skin). This is
  the drop-in replacement for the BS3 `dataTables.bootstrap` used by 120 view files.
- Keenicons needs no extra stylesheet; its `@font-face` lives in `plugins.bundle.css`.

### 2026-07-22 — Step 1: master layout rework

**Scope constraint (confirmed by user, applies to the whole project):**
`esna-new` **stays on CakePHP 2.10.19**. This is a front-end/view redesign only.
Do not upgrade CakePHP, change framework, or modify core files / routing / MVC structure.
Only `.ctp` views, layouts and `webroot/` assets are in scope. Controllers and models are
touched *only* if a view change needs a matching data change — never for framework reasons.

**Branding decision (confirmed by user):** keep the existing purple `#7c6ff0` palette and
Poppins exactly as-is. Do **not** revert to stock Metronic colours/fonts. Carry this
branding forward on every migrated page, using the `--lb-*` custom properties rather than
hard-coded hex values.

Files changed:

| File | Change |
|---|---|
| `app/View/Layouts/default.ctp` | reworked head + footer asset loading (1,384 → 1,209 lines) |
| `app/webroot/css/esna-theme.css` | **new** — 217 lines, brand layer extracted from the layout |
| `app/webroot/js/flatpickr-fr.js` | **new** — vendored flatpickr French locale (1,948 B) |
| `app/View/Elements/assets/datatables.ctp` | **new** — opt-in Metronic DataTables bundle |
| `app/webroot/metronic-selftest.html` | **new** — static asset/branding self-test harness |

What was done, and why:

1. **`plugins.bundle.js` now loads once**, in `<head>` (was: `<head>` *and* before
   `</body>`). Fixes TODO #9.
2. **Double jQuery removed.** `jquery-2.2.3.min` was loaded in `<body>` on top of the
   jQuery already inside `plugins.bundle.js`; the second instance replaced
   `window.$`/`window.jQuery` and silently detached plugins registered against the first
   (Select2 especially). Keeping the single bundle in `<head>` preserves the property the
   old author actually needed — `$` defined before any view's inline `<script>` runs —
   without the duplicate. Fixes TODO #10.
3. **Font Awesome 4.5.0 de-CDN'd.** No download needed: an identical local copy already
   existed at `webroot/css/font-awesome.min.css`, with its webfonts at `webroot/css/fonts/`
   (verified present). Swapped the CDN `<link>` for `$this->Html->css('font-awesome.min')`.
   Still loaded **only** because 170 un-migrated views use `fa-*`; remove when they're done.
4. **Flatpickr de-CDN'd — partially unnecessary.** Metronic's `plugins.bundle.{css,js}`
   already contains flatpickr (v4.3.0) *and* its CSS, so both CDN links were dropped.
   **Caveat found during verification:** the "janvier/lundi" strings inside the bundle come
   from **moment.js** locales, not flatpickr — flatpickr's bundled `l10ns` only contains
   `ar`. Dropping the CDN locale would therefore have silently reverted every date picker
   in this French app to English. The French locale alone was vendored to
   `webroot/js/flatpickr-fr.js` and is loaded after the bundle.
5. **Inline `<style>` extracted** — 207 lines removed from the layout into
   `webroot/css/esna-theme.css`, loaded last so its overrides still beat Metronic. Content
   is verbatim (brace balance verified 30/30); only the base indentation was stripped.
6. **DataTables wired as an opt-in element** rather than a global include: 
   `<?php echo $this->element('assets/datatables'); ?>` emits the Metronic Bootstrap 5
   bundle into the layout's `css`/`script` blocks. It is ~400 KB and only some pages have
   tables, so global loading would be wasteful — this mirrors how Metronic's own demo
   pages do it. This is the replacement for the BS3 `dataTables.bootstrap` in 120 views.
7. **Added `$this->fetch('css')` and `$this->fetch('script')` blocks** so migrated views
   can push assets to `<head>` / end-of-body instead of emitting `<link>`/`<script>` tags
   mid-page. Views that still call `Html->css()`/`Html->script()` without a `block` option
   keep working exactly as before — no regression for the 187/184 un-migrated views.

Verification performed:

- `php -l` on the modified layout → **no syntax errors**.
- Scripted resolution of **every** `Html->css()`/`Html->script()` path in the layout and
  element against `webroot/` → **12 resolved, 0 missing**.
- Grep assertions on the final layout: `jquery-2.2.3` = 0, `cdnjs` = 0, inline `<style>` = 0,
  one `plugins.bundle` CSS + one JS, one `scripts.bundle`.
- Keenicons `@font-face` URL traced: `plugins.bundle.css` requests
  `url(fonts/keenicons/keenicons-duotone.woff)` → resolves to
  `assets/plugins/global/fonts/keenicons/` ✓.
- **Not yet verified in a browser** — see TODO #13. `metronic-selftest.html` was written
  for exactly this: open `http://<host>/metronic-selftest.html` (or the file directly) and
  it runs 10 runtime assertions (single jQuery instance, Select2/flatpickr/daterangepicker
  attached, `flatpickr.l10ns.fr` present, Keenicons webfont applied, `--lb-primary` =
  `#7c6ff0`, Poppins active, `KTComponents` loaded) plus visual swatches, icon rows and
  Metronic form/button/badge samples.

### 2026-07-22 — Step 2: shared layout partials + dead-code removal

**A. Deleted 16 dead files** (user-approved). Each was verified to have **zero**
references anywhere in `app/` before removal, and all are recoverable from git history:

- 14 `*_old.ctp` views in the mobile groups (7,993 lines) — see §7.
- 2 `Layouts/default_old.ctp`, `Layouts/appmobile_old.ctp` (TODO #3, now closed).

View count: 376 → **361** (376 − 16 deleted + 1 new `Elements/assets/datatables.ctp`).

**B. Extracted the layout into partials.** `app/View/Layouts/default.ctp` went
**1,209 → 337 lines** (−72%). New files under `app/View/Elements/layout/`:

| Element | Lines | Contents |
|---|---:|---|
| `topbar.ctp` | 84 | `app-header` — notifications, mailbox, user menu, logout |
| `sidebar.ctp` | 757 | `app-sidebar` — the whole nav menu incl. inline `Droits` rights checks |
| `footer.ctp` | 20 | `app-footer` — ESNAPHARM / CRM VMP |
| `chat_ia.ctp` | 51 | floating "Chat with IA" launcher + BS5 modal |
| `flash.ctp` | 97 | **new** — flash messages as Metronic alerts (see below) |
| `page_header.ctp` | 77 | **new** — reusable page title + breadcrumb toolbar |

The layout now reads as a page skeleton: `element('layout/topbar')`,
`element('layout/sidebar')`, `element('layout/flash')`, `fetch('content')`,
`element('layout/footer')`, `element('layout/chat_ia')`.

**C. Flash messages now render server-side.** This was the one part of Step 2 that
changes behaviour, and it needed care:

- CakePHP 2's `SessionHelper::flash()` **hardcodes** its output for the `default`
  element — always `<div id="flashMessage" class="message">…</div>` — and, unlike other
  elements, adding an `Elements/default.ctp` does **not** override it. Of the **417**
  `setFlash()` calls in `app/Controller`, **345** pass only a message, **57** pass 2 args
  and **15** pass 3; the only non-default usage is
  `'default', array('class' => 'alert alert-success'|'alert alert-danger')`.
- The old layout coped by rewriting `#flashMessage` with jQuery inside
  `$(window).load()`. That fired only after *every* asset had downloaded, so the raw
  unstyled message was painted first, and it depended on jQuery being present.
- `Elements/layout/flash.ctp` instead post-processes the helper's output **server-side**:
  no flash-of-unstyled-content, no jQuery dependency, and **no controller changes** —
  all 417 `setFlash()` calls keep working untouched, which respects the
  "views only, don't touch business logic" constraint.
- Severity mapping is deliberately **identical to the old JS** so nothing changes
  semantically: `flash` → success, `auth` → danger, and an explicit `alert-*` class from
  the controller always wins. Unrecognised/custom markup is passed through untouched
  rather than mangled.
- The now-redundant `$(window).load()` rewriter was removed from the layout — left in
  place it would have **overwritten** the new server-rendered alert markup.

**D. New `page_header` element** gives every page a consistent Metronic toolbar
(`page-title` + `breadcrumb-separatorless` + optional actions slot). Markup copied from
Metronic's own `dist/account/activity.html` rather than hand-invented. Usage:

```php
<?php echo $this->element('layout/page_header', array(
    'title'  => 'Liste des clients',
    'crumbs' => array('Clients' => array('controller' => 'clients', 'action' => 'index'),
                      'Fiche client' => null),
    'actions' => '<a href="#" class="btn btn-primary btn-sm">Ajouter</a>',
)); ?>
```

Verification performed:

- `php -l` on the layout and all 6 elements → **no syntax errors**.
- **Content-preservation proof**: a script re-inlined every `element('layout/…')` call
  back into the layout, normalised whitespace/comments, and diffed against the
  pre-extraction backup. The **only** differences reported were the two intended ones
  (flash element replacing `Session->flash()`, and the deleted jQuery rewriter).
  `topbar`, `sidebar`, `footer` and `chat_ia` are **byte-identical** — the 746-line
  sidebar moved without a single markup change.
- `<div>` open/close balance checked per element: topbar 11/11, sidebar 54/54,
  footer 4/4, chat_ia 13/13. *(The first footer extraction over-grabbed 3 closing
  `</div>`s belonging to `app-main`/`app-wrapper`/`app-page`; caught by this check
  and fixed.)*
- Flash parsing unit-tested against the 7 real output shapes CakePHP produces for the
  `setFlash()` call styles found in the controllers (plain, auth, explicit success,
  explicit danger, embedded HTML, apostrophes/accents, custom-element passthrough) →
  **all 7 pass**.
- Confirmed `$this->Session` resolves inside an element on CakePHP 2.10: `View::__get()`
  → `HelperCollection::__isset()` → `load()` lazily instantiates the helper
  (`lib/Cake/View/HelperCollection.php:57`), which is why the old layout could use it
  without declaring `$helpers`.

### 2026-07-22 — Step 3, module 1: **Clients** (16 → 15 views) ✅

Self-test was confirmed green by the user before starting (jQuery 3.7.0 single instance,
Select2/flatpickr/daterangepicker attached, `flatpickr.l10ns.fr` present, KTComponents
loaded, Keenicons applied, `--lb-primary` = `#7c6ff0`, Poppins active).

| View | Lines | What changed |
|---|---:|---|
| `index.ctp` | 323→300 | rewritten: 4 AdminLTE `small-box` → Metronic stat cards; `.box` → `.card`; Ionicons → Keenicons; BS3 dropdown → Metronic `menu`; **8 CDN scripts + 3 jQuery loads → 1 element** |
| `add.ctp` | 646→380 | 280-line bespoke `<style>` removed; `.panel-*` → `.card-*`; styling moved into FormHelper `$options` |
| `edit.ctp` | 665→560 | same treatment; region/ville/secteur cascade untouched |
| `view.ctp` | 1339 | already largely Metronic; 2 static icons → Keenicons + matching JS |
| `allclients.ctp` | 901 | table + filters restyled, icon in a PHP-string label swapped |
| `archive.ctp` | 184 | bespoke `.custom-panel-*` → `.card-*` |
| `detail_visites.ctp` | 179 | `.box` → `.card`, modals → `data-bs-*` |
| `trouverdoublons.ctp` | 351 | bespoke card design kept, BS3 bits normalised |
| `system_index.ctp` | 181 | restyled (**orphan view — see TODO #19**) |
| `system_recherche.ctp` | 148 | restyled; DataTables include deliberately **not** added (AJAX fragment) |
| `statistique_visites.ctp` | 811 | `.box` → `.card`, CSS selectors realigned |
| `statistique_pot.ctp` | 184 | `.box` → `.card` |
| `statistique_pot_detail.ctp` | 75 | `.box` → `.card`, modals → BS5 |
| `statistique_liste_par_v_m.ctp` | 383 | `.box` → `.card`; bespoke `*-custom` classes kept |
| `info_client_par_mois.ctp` | 217 | `.box` → `.card`, empty-state icon → Keenicons |
| ~~`view_old.ctp`~~ | −2228 | **deleted** — unreferenced dead code (same criteria as the 16 already approved) |

Module total: 8,815 → 6,289 lines across 16 → 15 files.

**New files:** `app/webroot/css/esna-clients.css` — the only rules Metronic has no
equivalent for. Chiefly `#map-canvas { height: 300px }`: the Google Maps API renders into
an absolutely-positioned child, so without an explicit height the container collapses to
0px and the map silently disappears. Loaded via `Html->css(..., array('block' => 'css'))`.

**Verification (every file):**
- `php -l` on all 15 → clean.
- **Logic-preservation diff** vs the originals in `esna/`: 11/15 report *"logic identical"*;
  the other 4 differ only by the `page_header` element I added (`-0` removed) plus one
  intentional icon swap inside a PHP string label in `allclients.ctp`. **Across the whole
  module, zero business-logic statements were removed** — `requestAction` rights checks,
  foreach loops, `Html->link()/Url()` targets, form actions and hidden fields are intact.
- Comment-aware audit for 15 legacy patterns → clean (`.box`, `.panel`, `small-box`,
  `bg-aqua`, `well`, `col-xs-`, `data-toggle`, `input-group-addon`, `control-label`,
  `form-horizontal`, `label-*`, `<i class="fa">`, BS3 DataTables, duplicate jQuery).

**Three bugs found and fixed during this module** (all would have shipped silently):

1. **CSS selectors lagging renamed markup.** The migrator renamed `class="box-body"` →
   `card-body` but left `.box-body { }` rules in the views' own `<style>` blocks pointing
   at the old names, so bespoke styling silently died. Found in 6 files; the migrator now
   rewrites selectors too.
2. **Substring class matches.** A regex-based rewrite turned `search-icon-box` into
   `search-icon-card`. Replaced with token-level rewriting that only matches whole class
   names.
3. **JS/markup icon-toggle desync.** `Clients/view.ctp` toggles icons by comparing the
   *literal class string* (`if (clas == 'fa fa-plus')`). Swapping the markup to Keenicons
   without updating the comparison would break every expander. Fixed in lockstep for
   `boxtog()`; **deliberately reverted for `objettog()`** because the markup it drives
   lives in `Rapports/{add,edit,view}.ctp` and `Users/admin_statistique.ctp`, which are
   still on Font Awesome — see TODO #18.

**Tooling built** (kept out of the repo, in the session scratchpad): `metronize.py`, a
reusable AdminLTE/BS3 → Metronic migrator (token-safe class map, Keenicons icon map with
correct duotone `<span class="pathN">` counts, BS3→BS5 `data-bs-*` rewriting, asset
de-duplication), and `verify_php.py`, which proves a migrated view's PHP logic is
unchanged. Both were hardened by the bugs above and are ready for the remaining modules.

### 2026-07-23 — Step 3, module 2: **Visites** (17 → 13 views) ✅

**Scope note:** the user decided to skip local browser verification — the project will be
pushed to GitHub and validated by a colleague who has the real database. Verification here
is therefore `php -l` + logic-diff + code-integrity + legacy audit, all automated.

**Deleted 4 unreferenced files** (2,643 lines): `add_old.ctp` and the whole `add_old/`
directory (`addd.ctp`, `adddd.ctp`, `addold.ctp`). Same criteria as previous deletions —
verified zero references, recoverable from git.

| View | Lines | Notes |
|---|---:|---|
| `add.ctp` | 1306 | biggest view in the module; 26 `col-xs-*` → BS5, JS-driven ±icon toggles migrated with their JS |
| `visite_pharmacie.ctp` | 563 | `.panel`→`.card`, 11 `col-xs-*`, AdminLTE `info-box-icon` → Metronic `symbol` |
| `pointage.ctp` | 656 | 17 `.box` → `.card` |
| `statistique.ctp` | 640 | `.box`/`.panel` → `.card` |
| `archive.ctp` | 415 | DataTables → Metronic bundle |
| `suiviglobal.ctp` | 344 | DataTables → Metronic bundle |
| `system_statvisitbyparams.ctp` | 341 | icon toggles use `hasClass`/`addClass` — migrated markup + JS |
| `edit.ctp` | 313 | jQuery UI datepicker preserved |
| `system_top.ctp` | 232 | renders with an **empty layout** (fragment) — no asset element added |
| 3 × `system_get_*_forspecialite_byword.ctp` | 70 ea. | `.box` → `.card` + DataTables bundle |
| `couvertures.ctp` | 18 | already clean, unchanged |

Module total: 7,681 → 5,004 lines across 17 → 13 files. **Legacy audit: ALL CLEAN** across
all 17 patterns.

**jQuery UI is now served locally.** `add`/`edit`/`visite_pharmacie` call `.datepicker()`
(7 call sites). jQuery UI is **not** part of Metronic's `plugins.bundle`, so it must stay —
it is now loaded from `webroot/js/jquery-ui.min.js` with its CSS vendored to
`webroot/css/jquery-ui.min.css` plus the 6 `ui-icons_*.png` sprites it references
(`webroot/css/images/`), which the datepicker's prev/next arrows need. The French locale is
defined **inline in `add.ctp` itself** (`datepicker.regional.fr`), so no i18n file is
required — verified still present after migration.

---

### ⚠️ Two serious migrator bugs found this session — both silent

**Bug A — class rewriting corrupted code inside string literals.**
A `class="([^"]*)"` regex also matches string fragments in *code*:

```php
'<input type="hidden" class="latc' . $ii . '" value="..."'    // PHP
'<span class="concurclose' + ci + '" onclick="..."'           // JS
```

The token de-duplication then treated `+` / `.` as repeated class names and **deleted the
concatenation operators**. In `Visites/add.ctp` this removed 6 JS `+` operators, breaking
the dynamic objection/concurrent row builder — a core part of the visit form.

**The PHP case produced a parse error that `php -l` caught. The JS case did not** — the
file was valid PHP containing broken JavaScript, and linted perfectly clean.

Fixed in three layers: (1) class rewrites are applied only to segments between `<?php ?>`
**and** `<script>` blocks; (2) a `_is_code_fragment()` guard skips any `class="…"` whose
value contains concatenation syntax (`' +`, `. $`, `<?`); (3) a new checker,
`tools/verify_code_intact.py`, diffs structural token counts (JS/PHP concat operators,
braces, `function`/`foreach`/`if`) between `esna/` and the migrated file.

The checker was **validated against a deliberately corrupted file**: it reported
`js concat 28 -> 22` while `php -l` on the same file reported *"No syntax errors"* —
proving the gap it closes. Consequence of the fix: markup built inside JS strings is now
deliberately **not** auto-migrated; those spots are handled by hand.

**Bug B — jQuery UI was being stripped as a "duplicate jQuery".**
The CDN de-duplication rule matched `code.jquery.com/ui/1.12.0/jquery-ui.js`. jQuery **UI**
is a different library that Metronic does not bundle, and removing it silently broke all 7
`.datepicker()` call sites. The rule now matches only jQuery *core* (`jquery-<version>.js`
at the CDN root). Clients was checked and never affected.

**Latent issue repaired in Clients** while re-running the fixed tool: `.box-header-custom`
in a `<style>` block had been left pointing at markup already renamed to
`.card-header-custom`. Also caught 4 **Ionicons** in `Clients/allclients.ctp` that the
earlier audit had no pattern for (`ion ion-bag` etc.) — now Keenicons. Clients re-audited:
**ALL CLEAN**.

**Tooling now in `tools/`** (committed, so it travels with the repo):

| Tool | Purpose |
|---|---|
| `metronize.py` | AdminLTE/BS3 → Metronic migrator; token-safe, code-fragment-guarded |
| `verify_php.py` | proves PHP logic unchanged vs `esna/` |
| `verify_code_intact.py` | catches code corruption `php -l` cannot see |
| `audit_legacy.py` | comment-aware sweep for 17 legacy patterns |

### 2026-07-23 — Step 3, module 3: **Rapports** (11 views) ✅

Largest module so far: 13,782 → 13,674 lines, including `add.ctp` (3,771 lines),
`view.ctp` (3,448) and `edit.ctp` (2,752). All 11 views: `php -l` clean, **logic identical**
(`add.ctp` alone: 1,473 PHP statements unchanged), legacy audit **ALL CLEAN**.

| View | Lines | Notes |
|---|---:|---|
| `add.ctp` | 3771 | 21 `.box`, 168 grid, 87 FA icons, 86 modals; `.optionh` toggle markup + its JS |
| `view.ctp` | 3448 | same shape, read-only |
| `edit.ctp` | 2752 | same shape |
| `addsp.ctp` / `editsp.ctp` / `viewsp.ctp` | 594/246/362 | "sans produit" report variants |
| `index.ctp` / `index_dsm.ctp` / `index_vmp.ctp` | ~513 ea. | three role-scoped listings |
| `archive.ctp` | 493 | DataTables listing |
| `visites.ctp` | 578 | visit sub-listing |

**121 icon references migrated**, in three passes because the JS coupling differs:
- 87 toggle class-strings (`"fa fa-plus"` / `"fa fa-minus"`) → single-glyph `ki-plus`/
  `ki-minus`. **No `<span class="pathN">` children on these** — the JS swaps the whole class
  attribute, so duotone children would survive the swap and render as stray boxes.
- 34 static icons (`fa-user-md`, `fa-cloud-upload`) → duotone with proper path spans,
  preserving their inline `style` attributes.
- **A trap caught mid-migration:** the class-string *assignments* use double quotes
  (`"fa fa-plus"`) but the *comparisons* use single quotes (`'fa fa-plus'`). Migrating only
  the double-quoted form leaves `if (clas == 'fa fa-plus')` testing against a value that can
  no longer occur — every expander silently stops working. Both forms were migrated together
  and coherence verified per file.

Three residuals the migrator correctly refused to touch, handled by hand:
`class="box-body … boxtog<?php echo $i; ?>"` (class attribute containing PHP), `col-xs-*`
inside JS strings, and a bare `class="label-warning"` (no `label ` prefix, so unmapped).

### TODO #18 — closed

Investigation showed the coupling I had been cautious about **does not exist**: every view
carries its *own* copy of `objettog()`/`boxtogpo()` next to its *own* markup. There is no
cross-file dependency.

- `Rapports/{add,edit,view}.ctp` — markup + their own JS, migrated together ✅
- `Users/admin_statistique.ctp` — self-contained, stays on Font Awesome until the Users
  module; nothing in Rapports can break it ✅
- `Clients/view.ctp` — defines `objettog()` but emits **zero** `.optionh` markup, so the
  function is inert there. Moved to Keenicons for consistency ✅

### 🔴 Real corruption found in already-committed Clients code

`Clients/allclients.ctp` contained damage from the original buggy migrator (Bug A), shipped
in the Clients commit:

```js
original:   $(this).html('<input … placeholder="' + title + '" class="' + conte + '"/>');
committed:  $(this).html('<input … placeholder="' + title + '" class="' + conte"/>');
```

Invalid JavaScript — it would have thrown at runtime and killed the per-column filter setup
on the client listing. `php -l` reported the file clean throughout.

**Why it survived two earlier checks:** the ad-hoc verification I ran when first flagging
this file used a fixed-width context window (`.{30}…`) to compare occurrences, and the
damaged one sat too close to a line start to be captured. I reported "0 real losses" on
the strength of that. It was wrong.

Fixed, and the method replaced with `tools/scan_concat_damage.py`, which compares the
**multiset of concatenation expressions** per file — no context window, nothing can hide.
It was control-tested by re-introducing the exact bug: it reports
`LOST {'+ conte +': 1}` while `php -l` on the same file reports *"No syntax errors"*.
`verify_code_intact.py` now also excludes `<style>` blocks from token counts, since CSS
braces and font URLs like `Plus+Jakarta+Sans` produced false positives that were masking
signal.

**Full re-scan of all 39 migrated views across the 3 modules: no other concatenation
damage exists.**

### Verification status — 39 views, 3 modules

| Module | lint | logic | code intact | concat | legacy |
|---|---|---|---|---|---|
| Clients (15) | ✅ | ✅ *(4 files: `-0` removals, only `page_header` additions + 1 icon-in-label)* | ✅ | ✅ | ✅ |
| Visites (13) | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Rapports (11) | ✅ | ✅ identical | ✅ | ✅ | ✅ |

### 2026-07-23 — Step 3, module 4: **Users** (16 → 15 views) ✅

8,082 → 6,981 lines. Deleted `tableau_bord_super_old.ctp` (1,110 lines, unreferenced).
All 15 views: `php -l` clean, **logic identical**, legacy audit **ALL CLEAN**.

**`login.ctp` was rebuilt, not restyled.** It renders a *complete* HTML document (the
`login` layout is only `flash + content`) and was a standalone AdminLTE page —
`skin-blue.min`, `style.min`, Bootstrap 3, Font Awesome and Ionicons from CDNs. It is now a
Metronic sign-in card on the ESNAPHARM background, using the same bundle order as the main
layout so branding matches.

Preserved exactly, because `AuthComponent` depends on them — each verified present exactly
once in the markup: `$this->Form->create('User')`, the raw `</form>` close,
`name="data[User][username]"`, `name="data[User][password]"`, and the
`/img/background/dwa2.jpg` background.

Two JS blocks were dropped on purpose: the `$(window).load()` flash rewriter (flash is now
server-side — `Layouts/login.ctp` was switched to `element('layout/flash')`, without which
the page would have shown a raw unstyled `<div class="message">`), and an `$('input').iCheck()`
call — **iCheck was never loaded on that page**, so it had been throwing on every visit.

Because a full rewrite makes token-count comparison meaningless, `verify_code_intact.py`
gained an explicit `@migration-rewrite` opt-out marker, which `login.ctp` carries. Its form
contract is still asserted by `verify_php.py` (reports logic-identical).

**TODO #25 closed** — `admin_statistique.ctp`'s `.optionh` toggle migrated, markup and JS
together. As in Rapports, the assignments used double quotes and the comparisons single
quotes; 25 toggle strings plus 5 static icons converted, both forms moved together.

### 🟡 Third incomplete pattern set — found leftovers in modules already reported clean

Migrating Users surfaced AdminLTE classes none of my audit patterns covered:
`small-box`, `collapsed-box`, `box-tools`, `btn-box-tool`, `data-widget`,
`description-block`, and the Bootstrap 3 float helpers `pull-right` / `pull-left`.

A cross-module survey found them in **all four** modules — including Clients, Visites and
Rapports, each previously reported ALL CLEAN. `pull-right`/`pull-left` alone appeared in 15
files.

Both tools were extended (`metronize.py` token map + `audit_legacy.py` patterns) and the
migrator re-run across **every** migrated module. 17 files changed. All four now audit
ALL CLEAN against the enlarged 22-pattern set.

**Pattern:** this is the third time a clean report reflected the limits of the pattern set
rather than the state of the code (Ionicons in Clients, then concat damage in allclients,
now AdminLTE widget chrome). Each gap has been closed permanently in tooling, but "ALL
CLEAN" should be read as *"clean against the 22 patterns currently checked"*, not as proof
of a perfect result. The browser pass on real data remains the authority.

Other fixes in this pass:
- **Duplicate jQuery removed** from `tableau_bord_super.ctp` and `tableau_bord_super_cp.ctp`
  — both pulled jQuery 3.7.1 from CDN on top of the 3.7.0 inside `plugins.bundle.js`. The
  earlier CDN de-dup rule missed them because these tags carry `integrity`/`crossorigin`
  attributes.
- **Unused jQuery UI removed** from `tableau_bord_super_formail.ctp` (CSS + JS 1.13.2):
  verified zero widget calls (`.datepicker()`, `.autocomplete()`, …) and zero `ui-*`
  classes — the page uses a native `<input type="date">`. Contrast with Visites, where
  jQuery UI **is** required and was kept and vendored.
- `class="box-body boxtog<?php echo $i; ?>"` — class attribute containing a PHP echo, which
  the code-fragment guard correctly refuses to touch; renamed by hand.

### Verification status — 54 views, 4 modules

| Module | views | lint | logic | code intact | concat | legacy |
|---|---:|---|---|---|---|---|
| Clients | 15 | ✅ | ✅ *(4 files `-0` removals)* | ✅ | ✅ | ✅ |
| Visites | 13 | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Rapports | 11 | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Users | 15 | ✅ | ✅ identical | ✅ | ✅ | ✅ |

### 2026-07-23 — Step 3, module 5: **Listes** (12 views) ✅

3,885 → 3,812 lines. All 12 views: `php -l` clean, **logic identical** (one file differs by
an intentional icon swap inside a PHP link label), legacy audit **ALL CLEAN**.

### 🔴 Functional bug found and fixed: Bootstrap 5 modal that would not open

`Listes/listeretard.ctp` builds a link inside a PHP echo, with **single-quoted** attributes:

```php
echo "<a data-toggle='modal' data-target='#gridSystemModal' …>Visiter</a>";
```

Every `data-*` → `data-bs-*` rule in the migrator matched only the **double-quoted** HTML
form, so this survived untouched. Under Bootstrap 5 the old attribute names are ignored
entirely — the "Visiter" modal would silently do nothing.

Fixed here, and both tools hardened: the migrator now rewrites single-quoted variants, and
the audit pattern matches either quote style. **A sweep of all five migrated modules found
no other instance** — this was the only one, but it would have been invisible to `php -l`,
to the logic diff, and to the concat scan. Only a browser click would have revealed it.

Other work in this module:
- **jQuery UI, decided per file rather than by rule** — the three views that reference it
  needed three different answers:
  - `feuilleroute.ctp` — calls `.datepicker()` → **kept**, now served from `webroot`.
  - `feullederoutepharmacie.ctp` — loads it but calls **no** widget → **removed** (CSS+JS).
  - `remplire.ctp` — calls `.sortable()`, but its `<script>` include was **already commented
    out in `esna/`**, and jQuery UI was never loaded globally. So the drag-and-drop list has
    been broken upstream, before this migration. CSS de-CDN'd; the commented include left
    exactly as found. **Not fixed on purpose** — restoring a missing dependency changes
    behaviour, which is outside a restyle. See TODO #31.
- 12 Font Awesome icons → Keenicons. The 11 `fa-sort` ones carry an extra `lr-sort` class
  that is CSS-only (never swapped by JS), so the class was preserved alongside the Keenicon.
- `col-xs-12` inside a FormHelper `$options` div class → `col-12`.
- `valider_fuille_de_route.ctp` is an **orphan** (no controller action, no references) —
  restyled and left in place per the precedent set for `Clients/system_index.ctp`.

### Verification status — 66 views, 5 modules

| Module | views | lint | logic | code intact | concat | legacy |
|---|---:|---|---|---|---|---|
| Clients | 15 | ✅ | ✅ *(4 files, `-0` removals)* | ✅ | ✅ | ✅ |
| Visites | 13 | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Rapports | 11 | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Users | 15 | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Listes | 12 | ✅ | ✅ *(1 file, icon in label)* | ✅ | ✅ | ✅ |

Audit pattern set is now **22 patterns**, both quote styles.

---

### 2026-07-23 — Step 3, batch 1: **6 small CRUD modules** (42 → 41 views) ✅

`Prospects` (8), `Brochures` (8), `Rapportprocpects` (7 → 6), `Analyses` (7),
`Prospectcompagnes` (6), `Grosistes` (6).

Deleted `Rapportprocpects/ajouter_old.ctp` — no controller action, no references,
same class as the 14 dead `_old.ctp` files removed in Step 2.

#### 🔴 A styling regression the migrator itself introduced — in five modules already signed off

The markup pass renamed `bg-aqua`→`bg-primary`, `bg-yellow`→`bg-warning`,
`bg-green`→`bg-success`, but the `<style>`-block rewriter had a **hand-maintained
parallel list** covering only box/panel/input-group-addon. So in
`Rapportprocpects/fuille_route_conseiller.ctp` the CSS still read
`.fdr-wrapper .info-box.bg-aqua { background:#fff !important }` while the markup
said `bg-primary`.

That is not merely a lost tint. `bg-primary`/`bg-warning`/`bg-success` are **real
Bootstrap 5 utilities**, so with the local neutralizer no longer matching, those
three cards rendered as solid blue/yellow/green blocks with dark text on top.

Root-caused rather than patched: `_atomic_renames()` now **derives** the CSS
rename list from `CLASS_MAP` + `TOKENS`, the same maps the markup pass uses, so
the two can never drift again. Two further defects fell out of the fix:

- The selector regex used a `(?<![-\w])` lookbehind on the dot, which breaks
  **compound** selectors — `.info-box.bg-aqua` has a word char before `.bg-aqua`.
  A `.` cannot occur inside a CSS identifier, so the lookbehind was simply wrong.
- `.card.panel-primary` / `.card.box-info` rules matched nothing, because the
  markup collapses `panel panel-primary` to a bare `card`. Dead in **11 files**
  across Rapports, Visites, Listes, Brochures, Prospectcompagnes, Rapportprocpects.

Re-running the fixed migrator over all five finished modules changed **17 files**.

#### 🟡 Verification that verified nothing

`verify_php.py` and `verify_code_intact.py` take paths relative to `app/View/`.
Invoked with repo-relative paths (`--dir app/View/Prospects`) they matched zero
files and printed **ALL INTACT / ALL CLEAN** — a pass built on an empty set.
Both now refuse to report success when they compared nothing, and print the
count they actually checked.

#### 🟡 Three Font Awesome delivery paths, two of them invisible to the audit

The audit's icon pattern matched only the bare `fa` token, so it had never seen:

| Delivery | Where | Disposition |
|---|---|---|
| FA 4.5.0 local CSS | global, from the layout | stays until the last `fa-` is gone (TODO #11) |
| FA Pro **kit loader** → `kit-pro.fontawesome.com` | 4 Rapportprocpects views | removed from 3; kept in `ajouter.ctp` |
| FA 6.x CDN `<link>` → `site-assets.fontawesome.com` | 6 views in Rapports/Users/Visites | removed from 5; kept in `viewsp.ctp` |

FA6 also uses long-form prefixes (`fa-solid fa-plus`) that neither the swapper
nor the audit recognised. Both now handle `fa`/`fas`/`far`/`fal`/`fab` **and**
`fa-solid`/`fa-regular`/`fa-light`/`fa-thin`/`fa-brands`/`fa-duotone`, plus a new
`Font Awesome CDN` audit pattern. Removal is guarded: a file keeps its loader if
any FA class survives outside `<style>`.

#### 🟡 The icon path-count table was wrong

`ICON_PATHS` was hand-written and wrong for `ki-menu` (4 layers, listed as 1),
`ki-burger-menu` (4), `ki-archive` (3) and `ki-chart-line` (2) — those icons had
been rendering with **missing duotone layers** wherever they appeared. It also
had no notion of single-glyph icons, which must carry **no** `<span class="pathN">`
at all.

The table is deleted. Counts are now read from Metronic's own
`plugins.bundle.css` at run time, and an icon name absent from that stylesheet
warns and is left unconverted instead of silently rendering nothing. A repair
pass (`fix_icon_paths`) normalises already-converted icons; it touches only `<i>`
elements whose body is nothing but path spans, so icons wrapping real content are
never disturbed. 18 files corrected, 0 mismatches remain app-wide.

#### Judgement calls

- **`info-box` kept** in `Brochures/{index,detail_vmp}` and
  `Rapportprocpects/fuille_route_conseiller` (33 occurrences). These are *not*
  AdminLTE dependents: each file ships its own complete scoped CSS
  (`#programme-produit-page .info-box`, `.fdr-wrapper .info-box`), already present
  in `esna/`, and Metronic defines no colliding `.info-box`. Renaming markup and
  CSS in lockstep would be churn with real risk and no visual gain.
- **Sentiment scale kept on Font Awesome** — `fa-angry` … `fa-laugh-beam` is a
  five-point rating control; Keenicons has no faithful equivalent set and
  approximate glyphs would change what the control communicates. Same for
  `fa-bow-arrow` (Pro-only) and the `getFileIcon()` PDF/Word/Excel/image
  indicators in `Rapports/{view,viewsp}` — Keenicons has no file-type icons, so
  converting would collapse four distinguishable types into one.
- **`fa-spinner` → Bootstrap 5 `spinner-border`**, not a Keenicon: FA's spinner is
  animated (`fa-spin`) and a static glyph would leave a "loading" indicator that
  never moves.
- **Scoped `.form-group` rules re-pointed to `.mb-5`** (5 files) — the wrapper
  bounds the blast radius. **Unscoped ones left dead** (4 files): re-pointing
  `.description-block{padding:0!important}` onto `.d-block` would leak `!important`
  across every Metronic component on the page, and those rules were mostly
  compensating for AdminLTE defaults that no longer exist.
- **jQuery UI**: genuinely used by `.datepicker()` in all three files that load it
  (`Prospects/tableau_bord_conseiller`, `Prospectcompagnes/{add,edit}`), so it was
  de-CDN'd to the local copy rather than dropped, keeping its original position in
  the load order. The audit's `duplicate jQuery` pattern was matching
  `code.jquery.com/ui/…` and is now narrowed to jQuery **core**, the same line
  `metronize.py` already drew.
- **`Prospects/teleconseiller.ctp`**: the "Ajouter" link passed
  `array('class="btn bg-purple btn-flat margin"')` — a positional string, which
  CakePHP renders as a junk `0="class=…"` attribute, so the button never received
  a class and the local `.tc-wrapper .btn` rule had never applied. Corrected to a
  real `'class'` key; link target untouched.
- **JS-toggled icon** in `teleconseiller.ctp` migrated in lockstep with `boxtog()`,
  using single-glyph `ki-plus`/`ki-minus` (TODO #26).

### Verification status — 107 views, 11 modules

| Module | views | lint | logic | code intact | concat | legacy |
|---|---:|---|---|---|---|---|
| Clients | 15 | ✅ | ✅ *(4 files, `-0` removals)* | ✅ | ✅ | ✅ |
| Visites | 13 | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Rapports | 11 | ✅ | ✅ *(1 file, icon swaps)* | ✅ | ✅ | ⚠️ FA kept (file-type icons) |
| Users | 15 | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Listes | 12 | ✅ | ✅ *(2 files, icons + `data-bs-*`)* | ✅ | ✅ | ✅ |
| Prospects | 8 | ✅ | ✅ *(1 file, class-key fix)* | ✅ | ✅ | ✅ |
| Brochures | 8 | ✅ | ✅ identical | ✅ | ✅ | ⚠️ `info-box` kept by design |
| Rapportprocpects | 6 | ✅ | ✅ *(1 file, FA loader removed)* | ✅ | ✅ | ⚠️ FA kept (sentiment scale) |
| Analyses | 7 | ✅ | ✅ identical | ✅ | ✅ | ⚠️ `data-widget` (TODO #28) |
| Prospectcompagnes | 6 | ✅ | ✅ identical | ✅ | ✅ | ✅ |
| Grosistes | 6 | ✅ | ✅ identical | ✅ | ✅ | ✅ |

107 files linted, 0 failures. 107 compared for logic, 0 skipped. Every ⚠️ is a
recorded decision, not an unknown. Audit pattern set is now **24 patterns**.

---

### 2026-07-23 — Step 3, batch 2: **18 small CRUD modules** (95 views) ✅

`Evaluations`, `Echantillons`, `Documents`, `Commandes`, `Avences` (6 each);
`Secteurs`, `Produits`, `Packs`, `Offres`, `Objectifprofiles`, `Notefrais`,
`Groproduits`, `Games`, `Gadjets`, `Formations`, `Clientsproposes`,
`Categories`, `Actions` (5 each).

#### 🔴 The `\b` hyphen trap — silent class corruption in 13 files

`\b` treats a hyphen as a word boundary, so `\bbox-footer\b` also matched the
**tail** of `small-box-footer`, and `\bpanel-body\b` matched inside
`sub-panel-body`. The app's own component classes were being renamed:

| original | became | consequence |
|---|---|---|
| `small-box-footer` | `small-card-footer` | CSS still `.small-box-footer` → button unstyled |
| `custom-panel-title` | `custom-card-title` | CSS unchanged → heading unstyled |
| `form-actions-well` | `form-actions-card card-body bg-light` | **one class became three**, adding card padding/background |
| `well-custom` | `card card-body bg-light-custom` | nonsense class |
| `box-header-custom` | `card-header-custom` | CSS unchanged |

Crucially the `<style>` pass did **not** make the matching rename (its selector
regex correctly requires a literal `.` before the class), so markup and CSS
disagreed — the exact failure this tool exists to prevent, caused by the tool.

This was latent in the HTML path from the very first module and had already
shipped; the new PHP-side pass merely made it visible. Every `CLASS_MAP` pattern
now has its outer `\b` rewritten to `(?<![-\w])` / `(?![-\w])` at load time, so a
newly added rule cannot reintroduce it. A scan comparing every class token
against its `esna/` original found **23 corrupted tokens in 13 files**
(Clients, Brochures, Echantillons, Evaluations, Actions, Formations, Notefrais,
Offres) — all restored, 42 occurrences. `audit_legacy.py` had the same
looseness and was reporting those restored custom classes as leftovers; its
`box-header/body/title` pattern is now boundary-anchored too.

#### Classes written from inside PHP are now migrated

`_outside_php()` deliberately skips every PHP block, so classes that CakePHP
writes were never touched — FormHelper option arrays (`'class' => 'col-xs-6'`,
`'div' => array('class' => 'form-group')`) and echoed HTML
(`echo '<span class="label label-success">'`). Two new passes handle them:

- `fix_php_classes()` — rewrites only **provably static** literals. The guard
  (`_STATIC_CLASS`) rejects anything containing a quote, `.`, `+`, `$` or `<?`,
  and also rejects leading/trailing spaces: `'class' => 'form-control ' . $extra`
  has a load-bearing trailing space, and normalising it yields
  `form-controlbtn` at runtime. That was caught by the tool's own control test,
  not by `php -l`.
- `fix_mixed_classes()` — handles attributes that are part static, part PHP
  (`class="small-box <?php echo $styles[$i]; ?>"`). These were torn in half by
  the `_outside_php` split and never matched, so `small-box` survived in the
  markup while the `<style>` pass renamed `.small-box` → `.card` — leaving
  Notefrais' card styling pointed at nothing. Only literal segments are mapped;
  everything between `<?` and `?>` is untouched, and segment whitespace is
  preserved.

Biggest single win: `Rapports/{add,edit,view}.ctp` carried **96 Bootstrap 3
`label label-*` badges** inside PHP echo strings. BS5 has no `.label` class at
all, so every one of them was rendering as unstyled text. Now `badge
badge-light-*`.

#### Other fixes

- **Font Awesome modifiers survived onto Keenicons** (`ki-duotone ki-trash
  fa-fw`). FA4 is still loaded globally, so `.fa-fw{width:1.28em}` really
  applied and distorted the glyph. Stripped, in both the swapper and the repair
  pass.
- **A non-UTF-8 view crashed the migrator mid-run**, leaving a batch
  half-applied. `Droits/backup_database.ctp` is Latin-1. `process()` now detects
  the encoding, writes back in the **same** encoding (a silent re-encode would
  mangle every accented character) and skips-with-a-message rather than raising.
- **`Secteurs/view.ctp` dynamic icons** — `<i class="fa <?= $meta['icon'] ?>">`
  picks one of six client-type icons from a PHP table. Keenicons duotone glyphs
  render *nothing* without the right number of `<span class="pathN">` children
  and the count differs per icon, so the table now carries a `paths` key
  alongside the name. This is the only place in the app where an icon class is
  chosen at runtime.
- **Ionicons** (`ion ion-clipboard`, Notefrais ×2) — Ionicons was never loaded,
  in `esna/` either, so these had never rendered. Converted to `ki-clipboard`
  and `mr-1` → `me-1` for BS5.

#### Judgement calls

- `info-box` kept in `Formations/index.ctp` (self-styled locally, same as
  batch 1).
- `Objectifprofiles/default.ctp` is an **orphan** — a complete AdminLTE HTML
  document with no `default()` action and no references, like
  `Clients/system_index.ctp`. Its `data-toggle="offcanvas"` is AdminLTE's own
  sidebar toggle, dead with AdminLTE gone. Left in place per precedent.
- Unscoped dead `.form-group` rules left alone (4 files); the one scoped rule
  (`Offres/edit.ctp` `.product-row .form-group`) re-pointed to `.mb-5`.

### Verification status — 202 views, 29 modules

| | |
|---|---|
| `php -l` | **202 files, 0 failures** |
| logic diff | **202 compared, 0 skipped**, 25 files differ — all icon swaps, BS3→BS5 class renames inside PHP strings, and the 3 added statements for `Secteurs/view.ctp` icon spans. Every diff is `-N/+N` balanced except those 3. |
| code intact | ALL INTACT, every module |
| concat damage | ALL CLEAN |
| legacy audit | residuals in 9 files, **all recorded decisions** (FA kept ×3, `info-box` ×4, `data-widget` ×4 per TODO #28, orphan template ×1) |

Audit pattern set is now **25 patterns**, boundary-anchored.

---

### 2026-07-23 — Step 3, batch 3: **the 4-view tier** (13 modules, 52 views) ✅

`Zquestions`, `Types`, `Prospectaffaires`, `Pots`, `Odpobjectifs`, `Objectifs`,
`Marketings`, `Lignes`, `Jourferiers`, `Groventes`, `Digitals`,
`Autoechantiants`, `Absences`.

#### 🟡 The batch-2 boundary fix silently broke the CSS renames

Hardening `CLASS_MAP` to `(?<![-\w])…(?![-\w])` meant `_atomic_renames()` — which
extracted class names by matching the pattern text against `\\b([\w-]+)\\b` —
stopped matching **anything**. Every CLASS_MAP-derived CSS rename
(`.panel-heading`, `.panel-body`, `.box-footer`, `.box-body`, `.box-title` …)
quietly stopped being applied, leaving those rules aimed at markup that had
already been renamed. Only the two `TOKENS`-derived renames still worked, which
is why it wasn't obvious.

Caught by the audit's own `CSS .box/.panel rule` pattern, which lit up across 10
of the 13 modules. `_atomic_renames` now accepts either pattern shape; all 29
renames verified present. Re-running over every finished module changed **only
batch-3 files** — the earlier modules had already had their CSS renamed before
the regression, so nothing shipped broken.

Worth naming the shape of this: a fix for one hyphen-boundary bug introduced a
second bug in the code that *consumed* those same patterns. The derived-map
design (TODO #37) is what made it detectable — one place to fix, and the audit
caught the fallout immediately.

#### Icons

- 8 more Font Awesome names mapped (`fa-comment-o`, `fa-flag-o`, `fa-gamepad` →
  `ki-joystick`, `fa-paper-plane`, `fa-reply`, `fa-th-large`, `fa-thumbs-up/down`).
- **Ionicons now converted, not just flagged.** `Absences/index.ctp` had 6
  `ion-ios-time-outline`. Ionicons ships in `webroot` but is loaded by nothing —
  not by the Metronic layout, and not by `esna/`'s either — so these have been
  rendering as empty boxes for as long as the file has existed. New `ION_MAP` +
  `swap_ionicons()`, which also rewrites BS3/4 `mr-*`/`ml-*` to BS5 `me-*`/`ms-*`.
- `Groventes/view.ctp` had `class="fa fa-check-square-o btn btn-primary"` **on a
  `<button>`, inside a JavaScript string** that also contains `'+id+'`
  concatenations. Migrated by hand per TODO #21, moving the icon into a child
  `<i>` (the Metronic idiom) and touching no `+` operator.
- `Digitals/add.ctp`'s FA kit loader removed now that the module is migrated —
  it was the last deferred one outside the mobile track.

More BS3 classes recovered from inside PHP strings, including another
`label label-success` built via `str_replace()` in `Digitals/traitement_*` —
unstyled under BS5, now `badge badge-light-success`.

### Verification status — 254 views, 42 modules

| | |
|---|---|
| `php -l` | **254 files, 0 failures** |
| logic diff | **254 compared, 0 skipped**, 31 differ — all icon swaps and BS3→BS5 class renames inside PHP strings |
| code intact | ALL INTACT, 42/42 modules |
| concat damage | ALL CLEAN |
| legacy audit | residuals in 10 files, **all recorded decisions** |

Remaining residuals, unchanged in character: Font Awesome kept in 3 views
(TODO #34/#35), self-styled `info-box` in 4, inert `data-widget="collapse"` in 5
(TODO #28), and the orphan `Objectifprofiles/default.ctp` (TODO #42).

---

### 2026-07-23 — Step 3, batch 4: **the ≤3-view tail** (15 modules, 32 views) ✅ — desktop track complete

`Statistiques`, `Notevalidations`, `Notefraissecteurs`, `Hopitals`,
`Boitemails`, `Boiteidees`, `Actionrapports` (3 each); `Stockvisites`,
`Droits`, `Asm` (2 each); `Services`, `Plantournes`, `Pages`, `Notifications`,
`Gadgetclients` (1 each).

#### The Latin-1 file went through cleanly

`Droits/backup_database.ctp` is cp1252. The encoding handling added in batch 2
detected it, reported it, and left the file **byte-identical** — no re-encode,
no mangled accents, no crash. This was the specific risk flagged as TODO #40.

#### 🟡 The FA prefix is not always the first class

`Actionrapports/suivi.ctp` had `class="icon fa fa-info-circle"`. `swap_icons`
anchored the prefix at the **start** of the class attribute, so any icon with a
leading class of its own was silently skipped — no error, no audit hit until the
widened FA pattern from batch 1 caught it. The regex now allows leading classes
and carries them over (switched to named groups; positional indices had become
unreadable). An app-wide scan confirms **0 remaining** non-leading prefixes.

This matters more than one icon: the mobile track is dense with Font Awesome and
would have hit the same gap repeatedly.

#### Icons

13 more names mapped (`fa-inbox` → `ki-directbox-default`, `fa-bullseye` →
`ki-focus`, `fa-medkit` → `ki-bandage`, `fa-bell` → `ki-notification`,
`fa-bullhorn` → `ki-speaker`, `fa-exchange` → `ki-arrows-loop`, plus shield,
mobile, id-badge, cube, flag, facebook ×2).

`Notifications/index.ctp` is the **second** view where the icon class is chosen
at runtime (`$icon = 'fa-bullhorn' | 'fa-exchange' | 'fa-bell'`). Same treatment
as `Secteurs/view.ctp`: an `$iconPaths` value travels with each name and the
spans are emitted in a loop, because a duotone glyph renders nothing without
them and the count differs per icon.

Three icons **keep Font Awesome** — Keenicons has no lightbulb/idea glyph
(`Boiteidees` "Idée"), no bell-with-slash for a "no notifications" empty state,
and no hashtag for a "Code" column header. Substituting an approximate glyph
would change what each communicates. Consistent with the sentiment-scale and
file-type decisions; FA4 is loaded globally regardless until TODO #11.

More BS3 `label label-*` recovered from PHP strings — 6 in
`Asm/asm_visites_double.ctp` (distance badges), 5 in `Notevalidations/view.ctp`.

### Verification status — 286 views, 57 modules — DESKTOP TRACK COMPLETE

| | |
|---|---|
| `php -l` | **286 files, 0 failures** |
| logic diff | **286 compared, 0 skipped**, 38 differ — all icon swaps and BS3→BS5 renames inside PHP strings, plus the loop statements added for the two runtime-chosen icons |
| code intact | ALL INTACT, 57/57 modules |
| concat damage | ALL CLEAN |
| legacy audit | residuals in 15 files, **all recorded decisions** |

Residual ledger — nothing here is unknown:

| what | where | why |
|---|---|---|
| Font Awesome kept | `Rapports/{view,viewsp}`, `Rapportprocpects/ajouter`, `Boiteidees/index`, `Notifications/index`, `Asm/asm_visites_double` | no faithful Keenicons equivalent (TODO #34/#35) |
| self-styled `info-box` | `Brochures/{index,detail_vmp}`, `Rapportprocpects/fuille_route_conseiller`, `Formations/index` | complete scoped CSS, no AdminLTE dependency |
| inert `data-widget="collapse"` | `Analyses/portefeuille_vm`, `Secteurs/view`, `Notefrais/notedefrais`, `Categories/view`, `Types/view`, `Statistiques/statistiquesvisite`, `Stockvisites/index` | TODO #28, owner's call |
| orphan AdminLTE page | `Objectifprofiles/default.ctp` | TODO #42 |

**What remains overall:** the mobile/web-app track (§7 — `Appweb` 10,
`Appwebfinal` 13, `Appwebfinalv2` 14, `Visitemobileapis` 4 = 41 views on
Bootstrap 4.3.1/AdminLTE layouts), the `Elements/` directory, and the remaining
layouts (`appmobile`, `appmobilepro`, `mobile`, `error`, `blanck`, `Emails/`,
`Errors/`).

---

## 5. Migration checklist — inventory of `app/View/**/*.ctp`

**376 `.ctp` files** across 65 view directories.

### 5a. Legacy patterns by frequency (number of files containing each)

| Files | Pattern | Legacy origin | Metronic replacement |
|---:|---|---|---|
| 204 | `class="... box ..."` | AdminLTE panel | `.card` |
| 187 | `$this->Html->css(...)` | per-view CSS includes | audit; drop BS3 sheets |
| 184 | `$this->Html->script(...)` | per-view JS includes | audit; drop BS3 plugins |
| 177 | `col-xs-* / col-sm-* / col-md-* / col-lg-*` | Bootstrap 3 grid | BS5 grid (`col-*`, `col-md-*`; `col-xs-*` → `col-*`) |
| 170 | `fa` / `fa-*` | Font Awesome 4 | `ki-duotone ki-*` (Keenicons) |
| 165 | `box-body` | AdminLTE | `.card-body` |
| 151 | `box-header` | AdminLTE | `.card-header` |
| 146 | `box-title` | AdminLTE | `.card-title` |
| 123 | `table-bordered` | BS3 tables | `.table .table-row-bordered .gy-4` |
| 120 | `dataTables.bootstrap` | DataTables BS3 skin | Metronic `datatables.bundle` (BS5) |
| 110 | `class="... card ..."` | mixed/partial | verify — may already be BS5 |
| 107 | `panel` / `panel-heading` / `panel-body` | Bootstrap 3 | `.card` / `.card-header` / `.card-body` |
| 94 | `requestAction('/droits/getrole/...')` | rights check | **preserve verbatim** (not a style issue) |
| 69 | `select2` | BS3 select2 build | Metronic's bundled Select2 (`form-select` styling) |
| 68 | `modal-dialog` | BS3 modal | BS5 modal (`data-bs-*` attrs, no `data-dismiss`) |
| 65 | `form-group` | BS3 forms | `.mb-5` / `.fv-row` + `.form-label` |
| 59 | `form-horizontal` | BS3 forms | BS5 grid rows |
| 46 | `bg-aqua / bg-green / bg-red / …` | AdminLTE colors | `.bg-primary / .bg-success / .bg-danger …` |
| 32 | `box-footer` | AdminLTE | `.card-footer` |
| 30 | `btn-default` / `btn-flat` | BS3 buttons | `.btn-secondary` / `.btn-light` |
| 24 | `input-group-addon` | BS3 | `.input-group-text` |
| 15 | `label-success / label-danger / …` | BS3 labels | `.badge .badge-light-success …` |
| 11 | `info-box` | AdminLTE | Metronic stat card |
| 9 | `small-box` | AdminLTE | Metronic stat/mixed widget |
| 9 | `ion-*` | Ionicons | `ki-duotone` |
| 9 | `well` | Bootstrap 3 | `.card .card-body` / `.bg-light` |
| 8 | `bootstrap-datepicker` / `datepicker3` | BS3 datepicker | Metronic `flatpickr` / `tempus-dominus` |
| 6 | `nav-tabs` | BS3 tabs | BS5 `.nav-line-tabs` (`data-bs-toggle`) |
| 3 | `control-label` | BS3 | `.form-label` |
| 3 | `btn-block` | BS3 | `.w-100` |

### 5b. Per-module breakdown (sorted by view count)

`ctp` = number of `.ctp` files · `box`/`panel`/`grid`/`fa` = files containing that legacy
pattern · `KI` = files already using Keenicons.

| Module | ctp | box | panel | bs3-grid | fa | KI | Status |
|---|---:|---:|---:|---:|---:|---:|---|
| Layouts | 19 | 2 | 0 | 2 | 4 | 0 | ⬜ |
| Visites | ~~17~~ 13 | 0 | 0 | 0 | 0 | ✅ | **✅ done 2026-07-23** |
| Appwebfinalv2 | 17 | 3 | 2 | 2 | 8 | 0 | ⬜ |
| Users | ~~16~~ 15 | 0 | 0 | 0 | 0 | ✅ | **✅ done 2026-07-23** |
| Clients | ~~16~~ 15 | 0 | 0 | 0 | 0 | ✅ | **✅ done 2026-07-22** |
| Appwebfinal | 16 | 7 | 1 | 3 | 16 | 0 | ⬜ |
| Appweb | 16 | 7 | 2 | 5 | 16 | 0 | ⬜ |
| Listes | 12 | 0 | 0 | 0 | 0 | ✅ | **✅ done 2026-07-23** |
| Rapports | 11 | 0 | 0 | 0 | 0 | ✅ | **✅ done 2026-07-23** |
| Prospects | 8 | 7 | 2 | 4 | 4 | 0 | ⬜ |
| Brochures | 8 | 5 | 2 | 5 | 2 | 0 | ⬜ |
| Rapportprocpects | 7 | 5 | 4 | 7 | 6 | 0 | ⬜ |
| Analyses | 7 | 7 | 1 | 7 | 6 | 0 | ⬜ |
| Visitemobileapis | 6 | 5 | 3 | 3 | 5 | 0 | ⬜ |
| Prospectcompagnes | 6 | 6 | 4 | 6 | 1 | 0 | ⬜ |
| Grosistes | 6 | 2 | 0 | 2 | 0 | 0 | ⬜ |
| Evaluations | 6 | 5 | 0 | 4 | 5 | 0 | ⬜ |
| Echantillons | 6 | 4 | 2 | 1 | 1 | 0 | ⬜ |
| Documents | 6 | 3 | 1 | 2 | 1 | 0 | ⬜ |
| Commandes | 6 | 4 | 2 | 3 | 2 | 0 | ⬜ |
| Avences | 6 | 3 | 2 | 4 | 1 | 0 | ⬜ |
| Secteurs | 5 | 3 | 0 | 3 | 5 | 0 | ⬜ |
| Produits | 5 | 2 | 2 | 0 | 0 | 0 | ⬜ |
| Packs | 5 | 4 | 1 | 0 | 0 | 0 | ⬜ |
| Offres | 5 | 3 | 2 | 3 | 3 | 0 | ⬜ |
| Objectifprofiles | 5 | 1 | 2 | 3 | 1 | 0 | ⬜ |
| Notefrais | 5 | 5 | 4 | 4 | 2 | 0 | ⬜ |
| Groproduits | 5 | 3 | 2 | 2 | 0 | 0 | ⬜ |
| Games | 5 | 3 | 2 | 0 | 0 | 0 | ⬜ |
| Gadjets | 5 | 4 | 2 | 2 | 1 | 0 | ⬜ |
| Formations | 5 | 2 | 1 | 1 | 2 | 0 | ⬜ |
| Clientsproposes | 5 | 3 | 2 | 3 | 1 | 0 | ⬜ |
| Categories | 5 | 3 | 2 | 2 | 3 | 0 | ⬜ |
| Actions | 5 | 4 | 1 | 2 | 4 | 0 | ⬜ |
| Zquestions | 4 | 2 | 0 | 2 | 1 | 0 | ⬜ |
| Types | 4 | 2 | 2 | 1 | 2 | 0 | ⬜ |
| Prospectaffaires | 4 | 4 | 2 | 2 | 1 | 0 | ⬜ |
| Pots | 4 | 1 | 4 | 4 | 2 | 0 | ⬜ |
| Odpobjectifs | 4 | 2 | 4 | 4 | 0 | 0 | ⬜ |
| Objectifs | 4 | 0 | 2 | 1 | 0 | 1 | ⬜ |
| Marketings | 4 | 3 | 0 | 0 | 0 | 0 | ⬜ |
| Lignes | 4 | 1 | 3 | 1 | 1 | 0 | ⬜ |
| Jourferiers | 4 | 1 | 2 | 2 | 0 | 0 | ⬜ |
| Groventes | 4 | 2 | 2 | 3 | 1 | 0 | ⬜ |
| Elements | 4 | 0 | 0 | 0 | 2 | 0 | ⬜ |
| Digitals | 4 | 2 | 2 | 2 | 2 | 0 | ⬜ |
| Autoechantiants | 4 | 2 | 2 | 1 | 0 | 0 | ⬜ |
| Absences | 4 | 1 | 2 | 4 | 1 | 0 | ⬜ |
| Statistiques | 3 | 2 | 1 | 3 | 3 | 0 | ⬜ |
| Notevalidations | 3 | 0 | 0 | 0 | 2 | 0 | ⬜ |
| Notefraissecteurs | 3 | 2 | 1 | 1 | 0 | 0 | ⬜ |
| Hopitals | 3 | 1 | 2 | 0 | 2 | 0 | ⬜ |
| Errors | 3 | 0 | 0 | 0 | 2 | 1 | ⬜ |
| Boitemails | 3 | 0 | 0 | 3 | 3 | 0 | ⬜ |
| Boiteidees | 3 | 1 | 0 | 3 | 2 | 0 | ⬜ |
| Actionrapports | 3 | 3 | 1 | 1 | 3 | 1 | ⬜ |
| Stockvisites | 2 | 2 | 0 | 2 | 1 | 0 | ⬜ |
| Emails | 2 | 0 | 0 | 0 | 0 | 0 | ⬜ |
| Droits | 2 | 0 | 0 | 1 | 0 | 0 | ⬜ |
| Asm | 2 | 2 | 0 | 2 | 2 | 0 | ⬜ |
| Services | 1 | 1 | 1 | 1 | 0 | 0 | ⬜ |
| Plantournes | 1 | 0 | 0 | 1 | 0 | 0 | ⬜ |
| Pages | 1 | 0 | 0 | 0 | 0 | 0 | ⬜ |
| Notifications | 1 | 0 | 0 | 0 | 1 | 0 | ⬜ |
| Gadgetclients | 1 | 1 | 1 | 1 | 1 | 0 | ⬜ |

Files already containing Keenicons (partial prior migration, verify rather than rewrite):
`Actionrapports/index.ctp`, `Clients/view.ctp`, `Errors/pdo_error  .ctp`,
`Listes/detail_feuille_route.ctp`, `Listes/view.ctp`, `Objectifs/index.ctp`,
`Users/view.ctp`.

---

## 7. Mobile / API view groups — scope decision

**Question asked:** are `Appweb`, `Appwebfinal`, `Appwebfinalv2`, `Visitemobileapis`
(66 `.ctp` files) real visual pages, or pure JSON/data endpoints?

**Answer: they are real visual pages — IN SCOPE.** Evidence:

- Every one of the 66 files is HTML markup, 173–1,083 lines each, with 7–84 block-level
  tags (`<div>`/`<table>`/`<form>`/`<section>`) per file. None of them emit a JSON payload
  as their purpose.
- Their controllers render them through **mobile layouts**, not `default.ctp`:
  `AppwebController` → `appmobile`, `AppwebfinalController` → `appmobile`,
  `Appwebfinalv2Controller` → `appmobilepro`, `VisitemobileapisController` → `mobile`.
  A controller that renders a layout is producing a page for a browser.
- Where `json_encode` *does* appear in these files it is incidental — passing PHP data into
  an inline chart/map script (e.g. `maps.ctp` feeding marker coordinates to Leaflet), not
  the response body.

**The genuine API layer is elsewhere and has no views at all:** `ApimobileController` and
`Apimobilev1Controller` set `autoRender = false`, send
`header('Content-Type: application/json')` and `echo json_encode(...)` directly. Neither
has a directory under `app/View/`, so there is nothing there to migrate or to skip.
`Appwebfinalv2Controller` also has a few `autoRender = false` JSON actions mixed in
alongside its page actions — those actions render no `.ctp` and are unaffected by any view
work.

**Consequences for the migration (these pages need their own track):**

1. They do **not** use `default.ctp`, so the Step 1 layout work does not reach them. The
   three mobile layouts must be migrated separately before their pages can be restyled.
2. Those layouts are **not** Bootstrap 3 — `appmobile.ctp` and `appmobilepro.ctp` pull
   **Bootstrap 4.3.1 from a CDN**, and `mobile.ctp` uses AdminLTE's `app.min`. So this
   group is a BS4→BS5 + AdminLTE→Metronic job, a different conversion from the desktop
   pages' BS3→BS5.
3. **14 of the 66 files are dead code**: `*_old.ctp` (7,993 lines total) with **zero**
   references from any controller — `clients_old`, `index_old`, `maps_old`,
   `rapport_medcin_old`, `rapport_pharmacie_old`, `statistique_old`, `view_client_old`.
   Recommendation: exclude from migration (and preferably delete) rather than restyle
   ~8k lines of unreachable markup. **Pending user confirmation before deleting anything.**
4. Two `Visitemobileapis` files are "please upgrade your app" stubs rendered to users of
   outdated mobile builds (`rapport_medcin.ctp`, `rapport_pharmacie.ctp`, 13 lines each,
   AdminLTE `.box` + `callout`). Cheap to migrate, worth doing for consistency.

**Net in-scope count for this group: 52 files** (66 − 14 dead `_old` files).

---

## 6. Known issues / TODOs

1. **`app/webroot/metronic/` was empty in the legacy repo** — the old app's layout pointed
   at Metronic assets that were never committed, so the legacy UI was almost certainly
   rendering unstyled/broken. Resolved in esna-new by copying the assets in (see §4).
2. **Two font families in play** — Metronic ships Inter; the inherited layout forces
   Poppins with `!important` plus a custom purple palette (`#7c6ff0`). Need a decision:
   keep the custom purple/Poppins branding, or revert to stock Metronic. *Pending user
   input.*
3. **Duplicate/legacy layouts** — `default_old.ctp`, `appmobile_old.ctp` exist. Decide
   whether to delete or keep for reference.
4. **Odd filename** — `app/View/Errors/pdo_error  .ctp` contains two spaces before the
   extension. Likely a typo that makes it unreachable; flagged, not yet touched.
5. **`requestAction()` in views (94 files)** — an anti-pattern and a performance cost, but
   it is business logic. **Do not refactor during restyling.**
6. **Mobile/API view groups** (`Appweb`, `Appwebfinal`, `Appwebfinalv2`, `Visitemobileapis`,
   66 files total) use their own mobile layouts. Confirm whether these are in scope for the
   Metronic restyle or should stay as-is. *Pending user input.*
7. **CDN dependencies** in the layout (Google Fonts, flatpickr, Font Awesome 4). Consider
   vendoring them into webroot for offline/portable use.
8. **PHP 8 incompatibility** — CakePHP 2.10 will not run cleanly on PHP 8.x. Deployment
   target must be PHP 7.4 or lower.
9. **`plugins.bundle.js` is loaded twice** in the inherited layout — once in `<head>`
   (line 14) and again before `</body>` (line 1145). Wasteful and a re-init risk. To fix
   in Step 1.
10. **Double jQuery** — `plugins.bundle.js` already contains jQuery, yet the layout also
    loads `jquery-2.2.3.min` at line 239. Two jQuery instances means the last one wins and
    plugins registered on the first (Select2 et al.) can silently detach. Needs care: many
    views' inline scripts run *before* the bottom bundle, which is why the old author
    hoisted jQuery. To fix in Step 1 by loading `plugins.bundle.js` once, in `<head>`.
11. **Font Awesome 4 is still loaded from CDN** and 170 view files use `fa-*`. It must stay
    until those views are converted to Keenicons, then be removed. Track removal as the
    last cleanup task.
12. **Sidebar is ~750 hard-coded lines** inside the layout, mixing markup with `Droits`
    rights checks. Extracting it to an element is the main win of Step 2.
13. **No browser verification yet.** The only PHP on this machine is XAMPP **8.2.12**, and
    CakePHP 2.10 does not run on PHP 8 — so the app cannot currently be served locally.
    Step 1 was therefore verified by lint + path resolution + grep assertions, not by
    loading a page. `webroot/metronic-selftest.html` is deliberately dependency-free
    (static HTML, no PHP) so it can be opened in a browser right now to confirm the asset
    pipeline and branding. **A PHP 7.4 runtime is needed to test actual `.ctp` rendering.**
14. **Mobile layouts still on CDN Bootstrap 4.3.1** (`appmobile.ctp`, `appmobilepro.ctp`)
    and AdminLTE (`mobile.ctp`) — see §7. Needs its own migration track.
15. ~~14 dead `_old.ctp` files~~ — **CLOSED 2026-07-22**: 16 files deleted (14 mobile
    views + 2 `_old` layouts), user-approved, recoverable from git history.
16. **Conventions for page migration** (established in Step 2, apply from Clients on):
    - page title/breadcrumb → `$this->element('layout/page_header', array(...))`
    - table pages → `$this->element('assets/datatables')` instead of the BS3 pair
    - per-view assets → pass `array('block' => 'css')` / `array('block' => 'script')`
    - brand colours → use the `--lb-*` custom properties, never raw `#7c6ff0`
18. ~~`objettog()` icon toggle still on Font Awesome~~ — **CLOSED 2026-07-23**: no
    cross-file coupling exists (each view owns its copy of the function); Rapports migrated,
    `Clients/view.ctp` moved to Keenicons. Original note: in
    `Clients/view.ctp`. It drives `.objet/.optionh/.optionb` markup that lives in
    `Rapports/{add,edit,view}.ctp` and `Users/admin_statistique.ctp`. When those views are
    migrated, swap the markup **and** the class-string comparison in `objettog()` together,
    or the toggle stops matching. (The same function's `#icon` variant in
    `statistique_pot.ctp` / `statistique_visites.ctp` targets markup that does not exist in
    those files — pre-existing dead code, left untouched.)
19. **`Clients/system_index.ctp` is an orphan view** — no controller action and no
    references anywhere in `app/`. It was restyled for consistency but is unreachable.
    Candidate for deletion; **not deleted without approval** since it is not an `_old` file.
25. ~~`Users/admin_statistique.ctp` still uses Font Awesome~~ — **CLOSED 2026-07-23**
    with the Users module (markup + JS migrated together). Original note: for its `.optionh` toggle.
    It is self-contained (own markup + own `boxtogpo()`), so nothing is broken — migrate
    markup and JS together when the Users module is done.
28. **Inert collapse/remove buttons — DEFERRED by owner decision (2026-07-23).** Leave as
    they are: visually styled, non-functional, exactly as before the migration. There is
    not enough visibility into whether real users need that functionality; whoever owns the
    app post-migration decides once it is in use. Do not wire up or delete without that
    decision. Original note: in `Visites/pointage.ctp` and
    `Users/tableau_bord_super_formail.ctp`. Their `data-widget="collapse|remove"` attribute
    needed AdminLTE's `app.min.js`, which the Metronic layout does not load — so they have
    been dead since before this migration. The attribute (the last AdminLTE marker) was
    stripped; the buttons were left in place and now carry Metronic styling. **Product
    decision needed:** either wire them to Bootstrap 5 collapse or delete them. Removing
    visible controls was not mine to make unilaterally.
29. **`Users/tableau_bord_super_cp.ctp` is an orphan** (868 lines) — no controller action
    and no references, same situation as `Clients/system_index.ctp`. Restyled for
    consistency, left in place per the precedent set for that file.
31. **`Listes/remplire.ctp` drag-and-drop is broken upstream.** It calls
    `$("#sortable1, #sortable2").sortable()` but its jQuery UI `<script>` include was
    already commented out in `esna/`, and jQuery UI is never loaded globally — so the
    feature has not worked for some time, independent of this migration. To restore it,
    uncomment the include (or add `echo $this->Html->script('jquery-ui.min');`). Left
    untouched because reviving a dependency is a behaviour change, not a restyle.
32. **Attribute rewrites must cover both quote styles.** Markup inside PHP echo strings
    commonly uses single quotes (`data-toggle='modal'`), which double-quote-only rules miss
    entirely. Under Bootstrap 5 that means a control that silently does nothing — invisible
    to lint, logic diff and concat scan alike. Fixed in the tools 2026-07-23; if a new
    attribute rewrite is ever added, add both variants.
33. **`Prospectcompagnes/{add,edit}.ctp` load two datepicker plugins.** jQuery UI and
    bootstrap-datepicker both define `$.fn.datepicker`; bootstrap-datepicker loads second
    and wins, so the trailing `$(".date").datepicker("option","showAnim","drop")` — jQuery
    UI's API — is a no-op. Pre-existing; load order preserved exactly. Whoever owns the app
    can drop one of the two.
34. **Font Awesome is deliberately retained in three views.** `Rapportprocpects/ajouter.ctp`
    (five-point sentiment scale + `fa-bow-arrow`) and `Rapports/viewsp.ctp`
    (`getFileIcon()` PDF/Word/Excel/image indicators). Keenicons has no faithful
    equivalent for either set, so converting would lose meaning rather than restyle it.
    Both keep their external FA loader; every other view's loader was removed. Revisit
    only if someone picks a deliberate icon substitution.
35. **`Rapports/view.ctp` file-type icons have never rendered.** It emits
    `<i class="fas fa-file-pdf">` (Font Awesome 5/6 syntax) but loads no FA kit, and the
    global stylesheet is FA 4.5.0 — which has no `.fas` class and calls that icon
    `fa-file-pdf-o`. Identical in `esna/`, so this is upstream breakage, not migration
    damage. Left as-is per the precedent set for TODO #28 and #31; the fix is either an FA
    loader (as its sibling `viewsp.ctp` has) or FA4 names.
36. **A verification tool that matches no files must fail, not pass.** `verify_php.py` and
    `verify_code_intact.py` take paths relative to `app/View/`; given repo-relative paths
    they silently compared nothing and reported ALL CLEAN. Both now error out and print how
    many files they actually checked. Treat any "clean" result without a file count as
    unverified.
37. **Derive, never duplicate, the rewrite maps.** The `<style>`-block rewriter kept its own
    hand-maintained copy of the class renames; it drifted from `CLASS_MAP`/`TOKENS` and let
    markup and CSS disagree in five modules already signed off. It is now derived from
    those maps. Same lesson as #30, one layer down: a second list of the same facts will
    eventually disagree with the first.
38. **`\b` is the wrong boundary for CSS class names.** A hyphen IS a word boundary, so
    `\bbox-footer\b` matches inside `small-box-footer` and `\bpanel-body\b` inside
    `sub-panel-body`. Use `(?<![-\w])` / `(?![-\w])` for anything that matches a class
    name — in the migrator and in the audit. This silently renamed the app's own
    components in 13 files while leaving their CSS untouched.
39. **Whitespace in a class value can be load-bearing.** `'class' => 'form-control ' . $extra`
    concatenates; trimming that trailing space produces `form-controlbtn` at runtime, and
    the same applies to the literal segments of `class="a <?php ... ?> b"`. Any rewrite of a
    class value must preserve edge whitespace or refuse the value outright.
40. **Not every view is UTF-8.** `Droits/backup_database.ctp` is Latin-1. Read and write
    each file in its own encoding; a silent re-encode corrupts every accented character, and
    an unhandled decode error aborts a batch part-way through.
41. **Dynamic Keenicons need their path count carried with them.** A duotone glyph renders
    nothing without the right number of `<span class="pathN">` children, and the count
    varies per icon. Where the icon class is chosen at runtime (`Secteurs/view.ctp`), the
    count must travel in the same data structure — it cannot be assumed.
42. **`Objectifprofiles/default.ctp` is an orphan** — a complete AdminLTE HTML document
    (`<!DOCTYPE html>`, sidebar, `skin-blue`) with no `default()` action in
    `ObjectifprofilesController` and no references anywhere. Its
    `data-toggle="offcanvas"` is AdminLTE's sidebar toggle, dead now that AdminLTE is
    gone. Restyled and left in place per the `Clients/system_index.ctp` precedent
    (owner decision, 2026-07-23).
43. **Ionicons has never rendered in this app.** `webroot/css/ionicons.min.css` exists but
    no layout has ever loaded it — not the Metronic one, not `esna/`'s. Every `<i class="ion
    ion-*">` was an empty box. Converted to Keenicons rather than left, since restoring a
    visible icon is what the markup plainly intended.
44. **A fix can break its own consumers.** Hardening the CLASS_MAP boundaries (TODO #38)
    silently disabled `_atomic_renames()`, which parsed those same pattern strings — killing
    every CSS-side rename until the audit caught it one batch later. When changing the SHAPE
    of shared data, grep for everything that reads it.
45. **The Font Awesome prefix is not always the first class.** `class="icon fa fa-info-circle"`
    was skipped for four batches because `swap_icons` anchored the prefix at the start of the
    attribute. Fixed in batch 4; matters for the mobile track, which is dense with FA. When a
    pattern assumes token *position* rather than token *presence*, it will miss real cases.
30. **"ALL CLEAN" means "clean against the 25 patterns currently audited."** Seven separate
    times an incomplete pattern set produced a clean report on code that still had defects.
    When migrating a new module, expect to discover legacy classes not yet in
    `tools/audit_legacy.py`; add them and **re-run the migrator over all previously
    finished modules**, as was done on 2026-07-23.
26. **Icons whose class is swapped by JavaScript must be single-glyph Keenicons** (no
    `<span class="pathN">` children). The JS replaces the whole class attribute; duotone
    child spans would survive and render as stray boxes. Applies to every `ki-plus`/
    `ki-minus` toggle in Visites and Rapports.
27. **Class-string comparisons and assignments can use different quote styles** in the same
    file (`if (clas == 'fa fa-plus')` vs `.attr("class", "fa fa-plus")`). Migrate both or the
    toggle silently stops matching. Hit in Rapports/{add,edit,view}.
21. **Markup built inside JavaScript strings is not auto-migrated.** The migrator now
    refuses to rewrite class attributes inside `<script>` blocks and string literals
    (see Bug A, 2026-07-23) because doing so corrupts concatenation operators. Any legacy
    classes in JS-generated HTML must be handled by hand, per view. `Visites/add.ctp` and
    `visite_pharmacie.ctp` were done manually this way.
22. **`php -l` is not sufficient verification.** It validates PHP only; broken JavaScript
    inside a `.ctp` lints clean. Always run `tools/verify_code_intact.py` after migrating a
    module. Note it can false-positive on prose/URLs that read like `word + word + word`
    (e.g. a `Plus+Jakarta+Sans` font URL) — eyeball each hit.
23. **`Visites/system_addd` and `system_adddd` actions have no view files.** Both exist in
    `VisitesController` but `Visites/system_addd.ctp` / `system_adddd.ctp` do not, so
    calling them throws MissingViewException. Pre-existing upstream, untouched (controller
    logic is out of scope for this migration).
24. **jQuery UI must stay loaded** on `Visites/{add,edit,visite_pharmacie}` — Metronic does
    not bundle it and 7 `.datepicker()` calls depend on it. Assets are local now
    (`webroot/js/jquery-ui.min.js`, `webroot/css/jquery-ui.min.css` + `css/images/*.png`).
20. **`esna-clients.css` must stay loaded** on `add`/`edit`: `#map-canvas` needs its
    explicit 300px height or the Google Maps picker collapses to zero height.
17. **Bootstrap 3/4 compat shim is still active** in the layout — a delegated click
    handler that maps legacy `data-toggle`/`data-target`/`data-dismiss` to Bootstrap 5's
    `data-bs-*`. It keeps un-migrated views working. Once every view uses `data-bs-*`,
    delete the shim; until then, do **not** rely on it in newly migrated markup.
