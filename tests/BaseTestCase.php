<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected  \Ludens\Core\Application $app;

    protected function setUp(): void
    {
        parent::setUp();

        $reflection = new \ReflectionClass(\Ludens\Http\Support\SessionFlash::class);
        $property = $reflection->getProperty('instance');
        $property->setAccessible(true);
        $property->setValue(null);

        $this->app = require __DIR__ . '/../bootstrap/app.php';
    }
}
