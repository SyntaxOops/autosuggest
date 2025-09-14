<?php

defined('TYPO3') or die;

use SyntaxOOps\Autosuggest\Service\NewsSuggestService;
use SyntaxOOps\Autosuggest\Xclass\Form\Element\InputTextElement;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['autosuggest'][] = 'SyntaxOOps\\Autosuggest\\ViewHelpers';

// news autosuggest suggestion service
$GLOBALS['TYPO3_CONF_VARS']['EXT']['autosuggest']['news'] = NewsSuggestService::class;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Form\Element\InputTextElement::class] = [
    'className' => InputTextElement::class,
];
