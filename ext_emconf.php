<?php

$EM_CONF['autosuggest'] = [
    'title' => 'Auto Suggest FE & BE',
    'description' => 'A TYPO3 extension that adds auto suggestion for frontend and backend input fields.',
    'category' => 'misc',
    'author' => 'Haythem Daoud',
    'author_email' => 'hello@haythemdaoud.dev',
    'state' => 'stable',
    'uploadFolder' => false,
    'clearCacheOnLoad' => true,
    'version' => '13.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
