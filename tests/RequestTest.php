<?php

use PHPUnit\Framework\TestCase;
use Teardrops\Teardrops\Request;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversMethod(Request::class, 'clean')]
final class RequestTest extends TestCase
{
    public function testItCanRetrieveParameter(): void
    {
        $_REQUEST = ['name' => 'John Doe'];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = new Request();

        $this->assertSame('John Doe', $request->parameter('name'));
    }
}
