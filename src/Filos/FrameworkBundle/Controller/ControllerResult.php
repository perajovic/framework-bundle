<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\ParameterBag;

final class ControllerResult
{
    /**
     * @var ParameterBag
     */
    public $view;

    /**
     * @var ParameterBag
     */
    public $app;

    public function __construct(array $view = [], array $app = [])
    {
        $this->view = new ParameterBag($view);
        $this->app = new ParameterBag($app);
    }
}
