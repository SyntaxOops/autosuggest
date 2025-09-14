<?php

defined('TYPO3') or die;

use SyntaxOOps\Autosuggest\Service\NewsSuggestService;
use SyntaxOOps\Autosuggest\Xclass\Form\Element\InputTextElement;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function () {

    $extensionName = 'autosuggest';

    // Register auto suggest ViewHelpers.
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['as'][] = ViewHelpers::class;

    // news autosuggest suggestion service.
    $GLOBALS['TYPO3_CONF_VARS']['EXT'][$extensionName]['news'] = NewsSuggestService::class;

    // Extend backend input field
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Form\Element\InputTextElement::class] = [
        'className' => InputTextElement::class,
    ];

    // Load TS for auto suggest EXT.
    ExtensionManagementUtility::addTypoScript(
        $extensionName,
        'setup',
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:autosuggest/Configuration/TypoScript/setup.typoscript">',
    );
});

