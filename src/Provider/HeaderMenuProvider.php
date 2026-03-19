<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\Yaml\Yaml;

class HeaderMenuProvider
{
    private array $menu;

    public function __construct(string $path)
    {
        $this->menu = Yaml::parseFile($path)['header_navigation'] ?? [];
    }

    public function getMenu(): array
    {
        return $this->menu;
    }
}
