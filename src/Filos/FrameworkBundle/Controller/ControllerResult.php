<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

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

    /**
     * @param array $view
     * @param array $app
     */
    public function __construct(array $view = [], array $app = [])
    {
        $this->view = new ParameterBag($view);
        $this->app = new ParameterBag($app);
    }
}
