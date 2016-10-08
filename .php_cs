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

(c) Pera Jovic <perajovic@me.com>. All rights reserved.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return (new Symfony\CS\Config\Config())
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        '-psr0',
        'header_comment',
    ])
    ->finder((new Symfony\CS\Finder\DefaultFinder())->in([
        __DIR__.'/src',
        __DIR__.'/tests',
    ]));
