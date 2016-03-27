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

namespace Filos\FrameworkBundle\Response;

class ResponseHeaders
{
    const RESPONSE_STATUS_KEY = 'response_status';
    const PAGE_TITLE_KEY = 'page_title';
    const PAGE_CALLBACK_KEY = 'page_callback';
    const PAGE_DATA_KEY = 'page_data';
    const PAGE_TITLE_HEADER = 'X-Page-Title';
    const PAGE_CALLBACK_HEADER = 'X-Page-Callback';
    const PAGE_DATA_HEADER = 'X-Page-Data';
    const ERROR_HANDLED_HEADER = 'X-Error-Handled';
}
