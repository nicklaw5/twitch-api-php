<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src/')
    ->in('test/')
;

$config = new PhpCsFixer\Config();

return $config->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_no_alias_tag' => false,
        'phpdoc_separation' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
