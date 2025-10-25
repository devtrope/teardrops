<?php

namespace Tests;

use Ludens\Http\Request;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversMethod(Request::class, 'clean')]
final class RequestTest extends BaseTestCase
{
    public function testItCanRetrieveParameter(): void
    {
        $_REQUEST = ['name' => 'John Doe'];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = new Request();

        $this->assertSame('John Doe', $request->parameter('name'));
    }

    public function testItCanRetrieveJson(): void
    {
        $_REQUEST = [];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['HTTP_CONTENT_TYPE'] = 'application/json';

        $request = new Request();
        $request->setBody(json_encode(['name' => 'John Doe']));

        $this->assertSame('John Doe', $request->json('name'));
    }

    public function testItThrowsExceptionForNonExistentParameter(): void
    {
        $_REQUEST = [];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = new Request();

        $this->expectException(\InvalidArgumentException::class);
        $request->parameter('non_existent');
    }

    public function testItThrowsExceptionForNonExistentJsonKey(): void
    {
        $_REQUEST = [];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['HTTP_CONTENT_TYPE'] = 'application/json';

        $request = new Request();

        $this->expectException(\InvalidArgumentException::class);
        $request->json('non_existent');
    }
}
