<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Http;

final class ResponseHeaders
{
    const STATUS_CODE_KEY = 'status_code';
    const PAGE_TITLE_KEY = 'page_title';
    const ACTION_CALLBACK_KEY = 'action_callback';
    const ACTION_DATA_KEY = 'action_data';
    const PAGE_TITLE_HEADER = 'X-Page-Title';
    const ACTION_CALLBACK_HEADER = 'X-Action-Callback';
    const ACTION_DATA_HEADER = 'X-Action-Data';
    const ERROR_HANDLED_HEADER = 'X-Error-Handled';
}
