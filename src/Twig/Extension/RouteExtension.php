<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExtension extends AbstractExtension
{
    private ?RouteCollection $routes = null;

    public function __construct(private RouterInterface $router)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('route_defaults', [$this, 'getRouteDefaults']),
        ];
    }

    private function getRoutes(): RouteCollection
    {
        if (null === $this->routes) {
            $this->routes = $this->router->getRouteCollection();
        }

        return $this->routes;
    }

    public function getRouteDefaults(string $routeName): array
    {
        $route = $this->getRoutes()->get($routeName);

        if (!$route) {
            return [];
        }

        return $route->getDefaults();
    }
}
