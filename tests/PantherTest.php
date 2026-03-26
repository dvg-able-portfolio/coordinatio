<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Panther\PantherTestCase;

class PantherTest extends PantherTestCase
{
    #[Test]
    public function upAndRunnig()
    {
        $client = static::createPantherClient([
            'browser' => 'chrome'
        ]);
        $client->request('GET', '/');
        $this->assertSelectorTextContains('h2', 'Welcome to Coordinatio!');
    }
}
