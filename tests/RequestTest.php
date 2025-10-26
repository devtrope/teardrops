<?php

namespace Tests;

use Ludens\Http\Request;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversMethod(Request::class, 'clean')]
final class RequestTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $_GET = [];
        $_POST = [];
        $_REQUEST = [];
        $_SERVER = [];
    }

    public function testItCapturesBasicRequestInformation(): void
    {
        $_SERVER['REQUEST_URI'] = '/users/123';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();

        $this->assertSame('/users/123', $request->uri());
        $this->assertSame('GET', $request->method());
    }

    public function testItNormalizesMethodToUppercase(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'post';

        $request = Request::capture();

        $this->assertSame('POST', $request->method());
    }

    public function testItCapturesReferer(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['HTTP_REFERER'] = 'http://example.com/previous-page';

        $request = Request::capture();

        $this->assertSame('http://example.com/previous-page', $request->referer());
    }

    public function testItReturnsNullWhenNoReferer(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();

        $this->assertNull($request->referer());
    }

    public function testItCanRetrieveGetParameter(): void
    {
        $_GET = ['name' => 'John Doe'];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();

        $this->assertSame('John Doe', $request->get('name'));
    }

    public function testItReturnsDefaultValueForNonExistentGetParameter(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();

        $this->assertSame('Default', $request->get('non_existent', 'Default'));
    }

    public function testItRetrievesAllParameters(): void
    {
        $_GET = ['name' => 'John Doe'];
        $_POST = ['age' => '30'];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $request = Request::capture();

        $this->assertSame(
            ['name' => 'John Doe', 'age' => '30'],
            $request->all()
        );
        $this->assertSame('John Doe', $request->all()['name']);
    }

    public function testItChecksIfParameterExists(): void
    {
        $_GET = ['name' => 'John Doe'];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();

        $this->assertTrue($request->has('name'));
        $this->assertFalse($request->has('age'));
    }

    public function testItRetrievesPostParameters(): void
    {
        $_POST = ['username' => 'johndoe', 'password' => 'secret'];
        $_SERVER['REQUEST_URI'] = '/login';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $request = Request::capture();

        $this->assertSame('johndoe', $request->get('username'));
        $this->assertSame('secret', $request->get('password'));
    }

    public function testItMergesGetAndPostParameters(): void
    {
        $_GET = ['search' => 'query'];
        $_POST = ['page' => '2'];
        $_SERVER['REQUEST_URI'] = '/search';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $request = Request::capture();

        $this->assertSame('query', $request->get('search'));
        $this->assertSame('2', $request->get('page'));
    }

    public function testItRetrievesSpecificHeader(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();
        $headers = $this->getPrivateProperty($request, 'headers');
        $this->setPrivateProperty($headers, 'headers', [
            'Authorization' => 'Bearer token123',
            'User-Agent' => 'Mozilla/5.0'
        ]);

        $this->assertSame('Bearer token123', $request->header('Authorization'));
        $this->assertSame('Mozilla/5.0', $request->header('User-Agent'));
    }

    public function testItReturnsDefaultForMissingHeader(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();

        $this->assertNull($request->header('Missing'));
        $this->assertSame('default', $request->header('Missing', 'default'));
    }

    public function testItChecksIfRequestWantsJson(): void
    {
        $_SERVER['REQUEST_URI'] = '/api/users';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        
        $request = Request::capture();
        $headers = $this->getPrivateProperty($request, 'headers');
        $this->setPrivateProperty($headers, 'headers', [
            'Accept' => 'application/json'
        ]);

        $this->assertTrue($request->wantsJson());
    }

    public function testItRetrievesRawBody(): void
    {
        $rawBody = 'raw request body content';
        
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $request = Request::capture();
        $data = $this->getPrivateProperty($request, 'data');
        $this->setPrivateProperty($data, 'rawBody', $rawBody);

        $this->assertSame($rawBody, $request->body());
    }

    public function testItHandlesDifferentHttpMethods(): void
    {
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

        foreach ($methods as $method) {
            $_SERVER['REQUEST_URI'] = '/';
            $_SERVER['REQUEST_METHOD'] = $method;

            $request = Request::capture();

            $this->assertSame($method, $request->method());
        }
    }

    public function testItHandlesEmptyRequest(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();

        $this->assertSame([], $request->all());
        $this->assertNull($request->get('anything'));
    }

    public function testItHandlesSpecialCharactersInUri(): void
    {
        $_SERVER['REQUEST_URI'] = '/search?q=hello%20world';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $request = Request::capture();

        $this->assertSame('/search?q=hello%20world', $request->uri());
    }

    public function testItHandlesNestedArrayParameters(): void
    {
        $_POST = [
            'user' => [
                'name' => 'John',
                'email' => 'john@example.com',
                'address' => [
                    'city' => 'Paris',
                    'country' => 'France'
                ]
            ]
        ];
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $request = Request::capture();

        $user = $request->get('user');
        $this->assertIsArray($user);
        $this->assertSame('John', $user['name']);
        $this->assertSame('Paris', $user['address']['city']);
    }

    private function getPrivateProperty(object $object, string $property): mixed
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    private function setPrivateProperty(object $object, string $property, mixed $value): void
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }
}
