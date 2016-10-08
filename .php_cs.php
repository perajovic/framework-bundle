<?php

/*
 * This file is part of the Syx project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

$header = <<<'EOF'
This file is part of the FrameworkBundle project.

(c) Pera Jovic <perajovic@me.com>. All rights reserved.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return (new Symfony\CS\Config\Config())
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        'header_comment',
    ])
    ->finder((new Symfony\CS\Finder\DefaultFinder())->in([
        __DIR__.'/src',
        __DIR__.'/tests',
    ]));
