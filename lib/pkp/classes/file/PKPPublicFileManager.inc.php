<?php

/**
 * @file classes/file/PKPPublicFileManager.inc.php
 *
 * Copyright (c) 2013-2019 Simon Fraser University
 * Copyright (c) 2000-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PKPPublicFileManager
 * @ingroup file
 *
 * @brief Wrapper class for uploading files to a site/journal's public directory.
 */


import('lib.pkp.classes.file.FileManager');

class PKPPublicFileManager extends FileManager {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * Get the path to the site public files directory.
	 * @return string
	 */
	function getSiteFilesPath() {
		return Config::getVar('files', 'public_files_dir') . '/site';
	}

	/**
	 * Sanitize a public upload filename and reject executable extensions.
	 * @param $fileName string
	 * @return string|false
	 */
	function _sanitizePublicFilename($fileName) {
		$safeName = basename(str_replace(array("\0", '\\'), '', (string) $fileName));
		if ($safeName === '' || $safeName === '.' || $safeName === '..') {
			return false;
		}
		$ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
		if (in_array($ext, array('php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar', 'cgi', 'pl', 'py', 'sh', 'htaccess'), true)) {
			return false;
		}
		return $safeName;
	}

	/**
	 * Upload a file to the site's public directory.
	 * @param $fileName string the name of the file in the upload form
	 * @param $destFileName string the destination file name
	 * @return boolean
	 */
	function uploadSiteFile($fileName, $destFileName) {
		$safeName = $this->_sanitizePublicFilename($destFileName);
		if ($safeName === false) return false;
		return $this->uploadFile($fileName, $this->getSiteFilesPath() . '/' . $safeName);
	}

	/**
	 * Delete a file from the site's public directory.
	 * @param $fileName string the target file name
	 * @return boolean
	 */
	function removeSiteFile($fileName) {
		$safeName = $this->_sanitizePublicFilename($fileName);
		if ($safeName === false) return false;
		return $this->deleteFile($this->getSiteFilesPath() . '/' . $safeName);
	}
}

?>
