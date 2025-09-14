<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

isset($GLOBALS['TCA']) or die;

/**
 * Register TS static file
 */
ExtensionManagementUtility::addStaticFile(
    'autosuggest',
    'Configuration/TypoScript',
    'Auto Suggest'
);
