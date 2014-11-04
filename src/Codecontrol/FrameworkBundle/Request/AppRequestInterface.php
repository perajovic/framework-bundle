<?php

namespace Codecontrol\FrameworkBundle\Request;

use Symfony\Component\HttpFoundation\Request;

interface AppRequestInterface
{
    /**
     * @param Request $request
     */
    public function populateFields(Request $request);

    /**
     * @return boolean
     */
    public function isValid();

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return string
     */
    public function getFlattenErrors();
}
