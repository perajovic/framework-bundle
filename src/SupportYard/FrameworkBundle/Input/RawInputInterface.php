<?php

namespace SupportYard\FrameworkBundle\Input;

use Symfony\Component\HttpFoundation\Request;

interface RawInputInterface
{
    /**
     * @param Request $request
     */
    public function load(Request $request);
}
