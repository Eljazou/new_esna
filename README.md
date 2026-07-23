# CRM VMP — esna (Metronic rebuild)

Internal pharmaceutical-sales CRM. UI language: **French**. This repository is a
**visual rebuild** of the legacy `esna` app onto the **Metronic 8** design system
(Bootstrap 5). The PHP application logic is carried over unchanged — only the
views, layouts, and `webroot/` assets were rebuilt.

> **Read [`PROJECT_LOG.md`](PROJECT_LOG.md) first.** It is the single source of
> truth: §0 is the current state, §7 explains why the mobile app is out of scope,
> and the TODO ledger lists every deliberate "leave as-is" decision (dead
> buttons, orphan pages, a few kept Font Awesome icons). **Those are not bugs —
> do not "fix" them.**

---

## ⚠️ Requirements — read before you start

This is **CakePHP 2.10.19**. It has hard environment constraints:

| Need | Why |
|---|---|
| **PHP 7.4** (not 8.x) | CakePHP 2.x is not PHP 8 clean — it will not run on PHP 8. 7.4 is the ceiling. |
| **MySQL / MariaDB** | with the real database imported (see below). |
| **Apache with `mod_rewrite`** | the repo ships `.htaccess` files at root, `app/`, and `app/webroot/`. |
| **A virtual host** — *not* a subfolder | some paths are absolute (`/metronic/demo1/dist/assets/...`, `/img/...`). Serving from `http://localhost/esna-new/` will 404 every asset. Serve from a vhost root so `/` is the app. |

Nothing has been **visually tested yet.** Every check so far is syntax/logic
verification (`php -l`, logic-diff against the original, custom integrity
scanners) — never actual rendering. Confirming pages *look* right is the job this
setup is for.

---

## Setup

### 1. Get the code

```bash
git clone https://github.com/Eljazou/new_esna.git
cd new_esna
```

### 2. Database

Import the real database dump (ask the project owner — it is **not** in this
repo), then create the local config from the template:

```bash
cp app/Config/database.php.default app/Config/database.php
```

Edit `app/Config/database.php` and fill in your credentials. The defaults expect:

```php
'host'     => 'localhost',
'login'    => 'root',
'password' => 'YOUR_PASSWORD',
'database' => 'esna',        // match the DB name you imported into
'encoding' => 'utf8',        // required — the data has accented French text
```

`app/Config/database.php` is **gitignored** (it holds credentials) — it will not
be overwritten by `git pull`, and you should never commit it.

### 3. Writable tmp directory

CakePHP writes cache, logs, and sessions to `app/tmp/`. The folder structure is
in the repo (via `.gitkeep`), but the process serving PHP must be able to write
to it:

```bash
chmod -R 0777 app/tmp        # Linux/macOS; on Windows just ensure it's writable
```

### 4. Virtual host

Point the vhost **document root at `app/webroot/`** (standard CakePHP), or at the
project root if your setup expects the front controller there. Either way the app
must answer at `/`, not a subpath — see the requirements table above.

Minimal Apache example:

```apache
<VirtualHost *:80>
    ServerName crmvmp.local
    DocumentRoot "/path/to/new_esna/app/webroot"
    <Directory "/path/to/new_esna/app/webroot">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Add `127.0.0.1 crmvmp.local` to your hosts file, restart Apache, and open
`http://crmvmp.local/`.

### 5. Config to review (out of migration scope, but check before any real use)

`app/Config/core.php` ships `Security.salt` and `Security.cipherSeed` both set to
`'koko'` — a weak placeholder inherited from the original app. **Set real random
values before this runs anywhere public.**

---

## What's done

Web/desktop app only — **286 views across 57 modules**, plus shared elements and
6 layouts, migrated to Metronic 8 / Bootstrap 5. AdminLTE 2 and Bootstrap 3 are
fully removed. All views pass `php -l`, are logic-identical to the original, and
are integrity/concat-clean. See `PROJECT_LOG.md` §0 for the full scoreboard.

**The mobile app is out of scope** (`Appweb`, `Appwebfinal`, `Appwebfinalv2` app
views stay on Bootstrap 4.3.1) — see `PROJECT_LOG.md` §7. The one exception: the
14 legacy visit-report views on the `mobile` layout were moved off Bootstrap
3/AdminLTE and now use Bootstrap 5 (vendored locally, no Metronic), so no
AdminLTE/BS3 remains anywhere in the repo.

## Where to start testing

Once it renders, check these first — they are the highest-risk surfaces a static
check cannot see:

1. **`/clients`** — the most complete migrated surface; a good overall smoke test.
2. **`Listes/listeretard.ctp`** — click the **"Visiter" modal**. It had a bug that
   was invisible to every automated check and only showed on click.
3. **`Visites/add.ctp`** — exercise the **add/remove objection-row** buttons
   (JavaScript-built markup, hand-migrated).
4. **`Clients/view.ctp`** — the visit-history expand/collapse toggles should swap
   their icons in lockstep.
5. **The sidebar and topbar** — they render on every page and were migrated last;
   if one icon is wrong app-wide, it's here.

If a page looks wrong, diff it against the same file in the original `esna/`
repository: the PHP logic is provably identical, so any difference is purely
class/markup and quick to localize.

## Repository layout

```
app/
  Config/       database.php.default (copy to database.php), core.php, routes.php
  Controller/   business logic — carried over unchanged
  Model/        carried over unchanged
  View/         the migrated views, layouts, and elements
  webroot/      css/, js/, and metronic/demo1/dist/assets/ (Metronic bundle)
lib/Cake/       CakePHP 2.10.19 framework
tools/          Python verification scripts used during the migration
PROJECT_LOG.md  full migration record — read this first
```

## Tooling note

`tools/` holds the scripts that drove and verified the migration
(`metronize.py`, `audit_legacy.py`, `verify_php.py`, `verify_code_intact.py`,
`scan_concat_damage.py`). They need Python 3 and are only relevant if you extend
the migration — the app itself does not use them. Treat their "ALL CLEAN" output
as "clean against the patterns currently checked," not a guarantee of correct
rendering.
