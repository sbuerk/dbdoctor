<?php

$EM_CONF['dbdoctor'] = [
    'title' => 'TYPO3 Database doctor',
    'description' => 'Find and fix TYPO3 database inconsistencies',
    'category' => 'misc',
    'version' => '0.6.3',
    'module' => '',
    'state' => 'stable',
    'author' => 'Christian Kuhn',
    'author_email' => 'lolli@schwarzbu.ch',
    'constraints' => [
        'depends' => [
            'typo3' => '12.99.99-13.99.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];
