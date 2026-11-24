# OJS 2.4.8 — PHP 8.5 Compatibility

An open-source effort to make **Open Journal Systems (OJS) 2.4.8** (baseline `2.4.8-4`) run cleanly on **PHP 8.5** without breaking existing features, plugins, templates, or database compatibility.

## Baseline

- **Version:** `2.4.8.4-php8`
- **Upstream:** Public Knowledge Project (PKP) — OJS `2.4.8-4` (`ojs-2_4_8-4`, released January 30, 2019)
- **License:** GNU General Public License v2 (see [`docs/COPYING`](docs/COPYING))
- **Repository:** `https://github.com/fajaraditio/ojs-2.4.8-php8`

## Objectives

- Eliminate PHP 7.x–8.5 syntax errors, fatal errors, and removed language/extension usages.
- Resolve strict type errors, `null` passed to internal functions, and inherited method signature mismatches.
- Update or patch bundled third-party libraries in `lib/pkp/` (e.g., ADODB, Smarty, HTMLPurifier, PHPMailer) as needed for PHP 8.5.
- Preserve all OJS 2.4.8 workflows (installation, upgrade, submission, peer review, editorial, publishing, OAI-PMH, and core plugins).

## Contributing

Contributions, bug reports, and suggestions are welcome. To maintain code quality and compatibility:

1. Keep changes minimal and well-scoped so diffs against stock OJS `2.4.8-4` remain easy to audit.
2. Verify modified files with `php -l` under PHP 8.5 and test affected OJS flows end-to-end.
3. Never commit local `config.inc.php` credentials, `cache/` files, or `public/` user uploads.
4. Submit changes through Pull Requests for review before merging into the main branch.
5. Include clear descriptions of changes, testing procedures, and any potential compatibility impacts.

## Collaboration

This project is an independent open-source initiative built through individual contributions and organizational support. Collaboration helps make legacy journal infrastructure more compatible with modern environments.

### Main Contributor

**Aditio Fajar**

Project development, technical implementation, PHP compatibility improvements, and security assessment.

- **Email:** [aditio.pluto@gmail.com](mailto:aditio.pluto@gmail.com)
- **GitHub:** [@fajaraditio](https://github.com/fajaraditio)

### Main Sponsor

**ERUDISIA GLOBAL INNOVATION**

We gratefully acknowledge ERUDISIA GLOBAL INNOVATION for its support and sponsorship of this project.

- **Email:** [info@erudisia.com](mailto:info@erudisia.com)
- **Website:** https://erudisia.com/
- **Publishing Platform:** https://erudisiapub.com/

---

## Acknowledgements

This project is built upon the original work of the **Public Knowledge Project (PKP)** and its Open Journal Systems (OJS) community.

We acknowledge the contributions of the original developers and the open-source community whose work makes this independent compatibility effort possible.

**This project is not an official release or endorsement by PKP.**
