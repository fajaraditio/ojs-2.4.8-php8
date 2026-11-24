# Journal Manager Page Inspection — Errors Found

Inspected on `https://ojs-2.4.8.test/index.php/testing` (PHP 8.5.4, MySQL 8.4.9, Herd).

## 1. Server-Side PHP Fatal Errors & DB Errors (15 Pages, 10 Root Causes)

1. **`/manager/createUser`**
   - `Fatal error: Declaration of UserManagementForm::initData(&$args, &$request) must be compatible with Form::initData() in classes/manager/form/UserManagementForm.inc.php:141`
2. **`/manager/emails`**
   - `Fatal error: Declaration of ArrayItemIterator::nextWithKey() must be compatible with & ItemIterator::nextWithKey() in lib/pkp/classes/core/ArrayItemIterator.inc.php:90`
3. **`/manager/files`**
   - `Fatal error: Uncaught TypeError: join(): Argument #2 ($array) must be of type ?array, string given in pages/manager/FilesHandler.inc.php:154`
4. **`/manager/subscriptionsSummary`, `/manager/subscriptions/institutional`, `/manager/viewPayments`**
   - `Fatal error: Declaration of InstitutionalSubscription::isValid($domain, $IP, $check = SUBSCRIPTION_DATE_BOTH, $checkDate = null) must be compatible with Subscription::isValid($check = SUBSCRIPTION_DATE_BOTH, $checkDate = null) in classes/subscription/InstitutionalSubscription.inc.php:121`
5. **`/manager/importexport`**
   - `Fatal error: Uncaught TypeError: count(): Argument #1 ($value) must be of type Countable|array, null given in plugins/generic/tinymce/TinyMCEPlugin.inc.php:159`
6. **`/manager/plugins`**
   - `Fatal error: Declaration of WebFeedGatewayPlugin::fetch($args) must be compatible with GatewayPlugin::fetch($args, $request) in plugins/generic/webFeed/WebFeedGatewayPlugin.inc.php:100`
7. **`/manager/groups`**
   - `DB Error: You have an error in your SQL syntax; ... near 'groups WHERE assoc_type = 256 AND assoc_id = 1 ORDER BY context, seq LIMIT 0,25' at line 1` (unquoted `groups` reserved keyword in MySQL 8+)
8. **`/manager/reportGenerator`** (via `$$$call$$$/statistics/report-generator/fetch-report-generator`)
   - `Fatal error: Declaration of ReportGeneratorForm::fetch(&$request) must be compatible with Form::fetch(&$request, $template = null, $display = false) in controllers/statistics/form/ReportGeneratorForm.inc.php:79`
9. **`/manager/announcements`, `/manager/createAnnouncement`, `/manager/announcementTypes`, `/manager/createAnnouncementType`**
   - `Fatal error: Declaration of AnnouncementHandler::getContextId(&$request) must be compatible with PKPAnnouncementHandler::getContextId($request) in pages/manager/AnnouncementHandler.inc.php:53`
10. **`/manager/email`**
    - `Fatal error: Uncaught TypeError: count(): Argument #1 ($value) must be of type Countable|array, null given in pages/manager/ManagerHandler.inc.php:107`

## 2. Client-Side Console Errors (10 Pages, 1 Root Cause)

- Affected pages: `setup/1`–`setup/5`, `createSection`, `createReviewForm`, `subscriptionPolicies`, `createSubscriptionType`, `payments`.
- `/lib/pkp/lib/tinymce/jscripts/tiny_mce/tiny_mce_gzip.php?...` returned OJS HTML instead of JavaScript under Herd Valet routing, causing:
  - `Uncaught SyntaxError: Failed to execute 'appendChild' on 'Node': Unexpected token '<'`
  - `Uncaught ReferenceError: tinyMCE is not defined`
