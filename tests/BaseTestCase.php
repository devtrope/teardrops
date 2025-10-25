<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        (new \Ludens\Core\Application())->withPaths(
            templates: dirname(__DIR__) . '/templates',
            routes: dirname(__DIR__) . '/web/routes.php',
            cache: dirname(__DIR__) . '/web/cache'
        );
    }
}
