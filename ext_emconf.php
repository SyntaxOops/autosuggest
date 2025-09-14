<?php

$EM_CONF['autosuggest'] = [
    'title' => 'Auto Suggest FE & BE',
    'description' => 'A TYPO3 extension that adds auto completion plugin using custom rules',
    'category' => 'plugin',
    'author' => 'Haythem Daoud',
    'author_email' => 'haythemdaoud.x@gmail.com',
    'state' => 'stable',
    'uploadFolder' => false,
    'clearCacheOnLoad' => true,
    'version' => '10.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
