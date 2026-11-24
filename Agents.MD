# Agents.MD

Guidelines for AI coding agents working on the **OJS 2.4.8 → PHP 8.5** compatibility project.

## Project Goal

Make Open Journal Systems (OJS) `2.4.8-4` fully compatible with **PHP 8.5** without breaking existing features, plugins, Smarty templates, or database schemas.

## Codebase Overview

- `classes/` — Core OJS domain classes, DAOs, managers, and services.
- `controllers/` — Grid/listbuilder/modal controllers.
- `pages/` — Page handlers for public, author, reviewer, editor, and admin routes.
- `plugins/` — Core and generic/auth/importexport/metadata/theme plugins.
- `lib/pkp/` — Shared PKP library and bundled third-party dependencies (ADODB, Smarty, HTMLPurifier, etc.).
- `templates/` — Smarty `.tpl` templates.
- `tools/` — CLI utilities (`install.php`, `upgrade.php`, `runScheduledTasks.php`, etc.).
- `docs/` — Upstream OJS documentation and license (`docs/COPYING`).

## Rules & Conventions

1. **Preserve Behavior First**
   - Do not alter OJS business logic, URLs, database schemas, or template variables unless required for PHP 8.5 compatibility.
   - Maintain backward compatibility with existing OJS 2.4.8 databases and plugins.

2. **Fix Root Causes, Not Symptoms**
   - Replace removed functions/syntax (`each()`, `create_function()`, `{}` offsets, PHP 4 constructors, `=& new`, non-canonical casts like `(integer)`/`(boolean)`/`(double)`) cleanly.
   - Handle `null` inputs explicitly before calling PHP internal functions (`strlen`, `trim`, `htmlspecialchars`, `preg_match`, etc.) instead of hiding bugs with `@`.
   - Fix inherited method signature mismatches (`Declaration of ... must be compatible with ...`) and `Countable` / `Iterator` / `Serializable` / `ReturnTypeWillChange` issues accurately.
   - Use `#[AllowDynamicProperties]` only where dynamic properties are an intentional OJS/PKP pattern, or declare properties explicitly when the set of fields is fixed.

3. **Keep Diffs Clean & Auditable**
   - Avoid sweeping reformatting or unrelated refactors.
   - Document non-obvious PHP 8.5 compatibility fixes with brief inline comments explaining *why*.

4. **Verification**
   - Run PHP 8.5 syntax linting (`php85 -l`) on every modified PHP file.
   - On macOS with Herd, PHP 8.5 is located at:
     `"/path/to/php85"`
   - Test affected routes, CLI tools, or workflows after changes whenever possible.

5. **Repository Hygiene**
   - Never commit `config.inc.php` (contains local environment/DB settings), `cache/` compiled artifacts, or `public/` uploaded files.
