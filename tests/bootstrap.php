<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

// temporarily - start (will be removed)
// Reset test database on each test run
passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:database:drop --force --if-exists 2>&1',
    __DIR__
));
passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:database:create 2>&1',
    __DIR__
));
//passthru(sprintf(
//    'APP_ENV=test php "%s/../bin/console" doctrine:migrations:migrate --no-interaction 2>&1',
//    __DIR__
//));
passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:schema:update --force --no-interaction 2>&1',
    __DIR__
));
// temporarily - end 