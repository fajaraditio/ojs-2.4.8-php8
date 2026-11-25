<?php

/**
 * @file plugins/generic/staticPages/StaticPagesHandler.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package plugins.generic.staticPages
 * @class StaticPagesHandler
 *
 * Find the content and display the appropriate page
 *
 */

import('classes.handler.Handler');

class StaticPagesHandler extends Handler {
	function index($args = array(), $request = null) {
		Request::redirect(null, null, 'view', Request::getRequestedOp());
	}

	function view ($args) {
		if (count($args) > 0 ) {
			AppLocale::requireComponents(LOCALE_COMPONENT_PKP_COMMON, LOCALE_COMPONENT_APPLICATION_COMMON, LOCALE_COMPONENT_PKP_USER);
			$journal =& Request::getJournal();
			$journalId = $journal?$journal->getId():0;
			$path = $args[0];

			$staticPagesPlugin =& PluginRegistry::getPlugin('generic', STATIC_PAGES_PLUGIN_NAME);
			$templateMgr =& TemplateManager::getManager();

			$staticPagesDao =& DAORegistry::getDAO('StaticPagesDAO');
			$staticPage = $staticPagesDao->getStaticPageByPath($journalId, $path);

			if ( !$staticPage ) {
				Request::redirect(null, 'index');
			}

			// and assign the template vars needed with locale fallback
			$pageTitle = $staticPage->getStaticPageTitle();
			if (empty($pageTitle)) {
				$primaryLocale = $journal ? $journal->getPrimaryLocale() : AppLocale::getPrimaryLocale();
				$pageTitle = $staticPage->getTitle($primaryLocale);
			}
			if (empty($pageTitle)) {
				$titles = $staticPage->getTitle(null);
				if (is_array($titles)) {
					foreach ($titles as $val) {
						if (!empty($val)) {
							$pageTitle = $val;
							break;
						}
					}
				}
			}
			if (empty($pageTitle)) {
				$pageTitle = $path;
			}

			$pageContent = $staticPage->getStaticPageContent();
			if (empty($pageContent)) {
				$primaryLocale = $journal ? $journal->getPrimaryLocale() : AppLocale::getPrimaryLocale();
				$pageContent = $staticPage->getContent($primaryLocale);
			}
			if (empty($pageContent)) {
				$contents = $staticPage->getContent(null);
				if (is_array($contents)) {
					foreach ($contents as $val) {
						if (!empty($val)) {
							$pageContent = $val;
							break;
						}
					}
				}
			}

			$templateMgr->assign('title', $pageTitle);
			$templateMgr->assign('content', $pageContent);
			$templateMgr->display($staticPagesPlugin->getTemplatePath().'content.tpl');
		}
	}
}

?>
