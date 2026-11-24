# OJS 2.4.8 — PHP 8.5 Compatibility

An open-source effort to make **Open Journal Systems (OJS) 2.4.8** (baseline `2.4.8-4`) run cleanly on **PHP 8.5** without breaking existing features, plugins, templates, or database compatibility.

## Baseline

- **Version:** `2.4.8.4-php8`
- **Upstream:** Public Knowledge Project (PKP) — OJS `2.4.8-4` (`ojs-2_4_8-4`, released January 30, 2019)
- **License:** GNU General Public License v2 (see [`docs/COPYING`](docs/COPYING))
- **Repository:** `git@github.com:<your-github-user>/ojs-2.4.8-php8.git`

## Objectives

- Eliminate PHP 7.x–8.5 syntax errors, fatal errors, and removed language/extension usages.
- Resolve strict type errors, `null` passed to internal functions, and inherited method signature mismatches.
- Update or patch bundled third-party libraries in `lib/pkp/` (e.g., ADODB, Smarty, HTMLPurifier, PHPMailer) as needed for PHP 8.5.
- Preserve all OJS 2.4.8 workflows (installation, upgrade, submission, peer review, editorial, publishing, OAI-PMH, and core plugins).

## Contributing

1. Keep changes minimal and well-scoped so diffs against stock OJS `2.4.8-4` remain easy to audit.
2. Verify modified files with `php -l` under PHP 8.5 and test affected OJS flows end-to-end.
3. Never commit local `config.inc.php` credentials, `cache/` files, or `public/` user uploads.
