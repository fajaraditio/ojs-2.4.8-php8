<?php

/**
 * Security gate for TinyMCE jbimages plugin.
 * Require an authenticated OJS user session.
 */
function is_allowed() {
	return class_exists('Validation') && Validation::isLoggedIn();
}

?>
