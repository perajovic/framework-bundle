<?php

namespace Filos\FrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\ParameterBag;

class ControllerResult
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
