<?php

// Enable autosuggest for header field in text element
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['author']['config']['autosuggest'] = [
    'identifier' => 'news',
    'storage_pids' => '5',
    'additionalUriParameters' => [
        'table' => 'tx_news_domain_model_news',
        'field' => 'title',
        'recursive' => true, // include subfolder of storage_pids
        'recursive_depth' => 999,
    ], // applied to data-json-path uri path
    'additionalParameters' => [
        'data-combobox-case-sensitive' => 'no',
        'data-combobox-search-option' => 'containing',
        'data-combobox-limit-number-suggestions' => 10,
    ],
];
