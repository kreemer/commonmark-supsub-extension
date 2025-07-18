<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PHP82Migration:risky' => true,
        'strict_param' => true,
        'header_comment' => [ 'header' => file_get_contents(__DIR__.'/LICENSE'), 'location' => 'after_open' ]
    ])
    ->setFinder($finder)
;
