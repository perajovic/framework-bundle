<?php 

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */
declare(strict_types=1);

namespace Filos\FrameworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UrlCatcherController
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var string
     */
    private $defaultRoute;

    public function __construct(Router $router, string $defaultRoute)
    {
        $this->router = $router;
        $this->defaultRoute = $defaultRoute;
    }

    public function indexAction(): RedirectResponse
    {
        return new RedirectResponse('' === $this->defaultRoute ? '/' : $this->router->generate($this->defaultRoute));
    }
}
