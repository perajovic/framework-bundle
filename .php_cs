<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

$header = <<<'EOF'
This file is part of the Filos FrameworkBundle project.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
(c) Pera Jovic <perajovic@me.com>. All rights reserved.
EOF;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'combine_consecutive_unsets' => true,
        'no_useless_else' => true,
        'ordered_class_elements' => true,
        'ternary_operator_spaces' => false,
        'ordered_imports' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'psr0' => false,
        'header_comment' => ['header' => $header, 'location' => 'after_open', 'separate' => 'top'],
        'declare_strict_types' => true
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([
                 __DIR__.'/src',
                 __DIR__.'/tests',
             ])
    );
