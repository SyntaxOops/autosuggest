<?php

defined('TYPO3') or die;

use SyntaxOOps\Autosuggest\Service\NewsSuggestService;
use SyntaxOOps\Autosuggest\Xclass\Form\Element\InputTextElement;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['autosuggest'][] = 'SyntaxOOps\\Autosuggest\\ViewHelpers';

// news autosuggest suggestion service
$GLOBALS['TYPO3_CONF_VARS']['EXT']['autosuggest']['news'] = NewsSuggestService::class;

// Extend backend input field
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Form\Element\InputTextElement::class] = [
    'className' => InputTextElement::class,
];

// Add JS and CSS
ExtensionManagementUtility::addTypoScriptSetup('
    page {
        includeJSFooter {
            jsAutosuggest = EXT:autosuggest/Resources/Public/Js/autosuggest.js
        }
        includeCSS {
            cssAutosuggest = EXT:autosuggest/Resources/Public/Css/autosuggest-bootstrap.css
        }
    }
');
