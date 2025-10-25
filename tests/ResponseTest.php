<?php

namespace Tests;

use Ludens\Http\Response;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversMethod(Response::class, 'clean')]
final class ResponseTest extends BaseTestCase
{
    public function testItCanRedirect(): void
    {
        $response = Response::redirect('https://example.com');

        $this->assertSame('', $response->body());
        $this->assertSame('https://example.com', $response->header('Location'));
        $this->assertSame('text/html; charset=UTF-8', $response->header('Content-Type'));
    }

    public function testItThrowsExceptionForNullUrlInRedirect(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('URL for redirection cannot be null');

        Response::redirect(null);
    }

    public function testItThrowsExceptionWhenSendingResponseTwice(): void
    {
        $response = new Response();

        $response->send();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Response has already been sent');

        $response->send();
    }

    public function testItCanSetFlashData(): void
    {
        session_start();
        $_SESSION = [];

        $response = new Response();
        $response->withFlash('success', 'Operation completed successfully.');

        $this->assertArrayHasKey('flash', $_SESSION);
        $this->assertSame('success', $_SESSION['flash']['type']);
        $this->assertSame('Operation completed successfully.', $_SESSION['flash']['message']);
    }

    public function testItCanSetErrors(): void
    {
        session_start();
        $_SESSION = [];

        $response = new Response();
        $errors = ['name' => 'Name is required.', 'email' => 'Email is invalid.'];
        $response->withErrors($errors);

        $this->assertArrayHasKey('errors', $_SESSION);
        $this->assertSame($errors, $_SESSION['errors']);
    }

    public function testItCanSetOldData(): void
    {
        session_start();
        $_SESSION = [];

        $response = new Response();
        $oldData = ['name' => 'John Doe', 'email' => 'john.doe@test.com'];
        $response->withOldData($oldData);

        $this->assertArrayHasKey('old', $_SESSION);
        $this->assertSame($oldData, $_SESSION['old']);
    }

    public function testItCanSendJsonResponse(): void
    {
        ob_start();

        $data = ['message' => 'Hello, World!'];
        $response = Response::json($data);
        $response->send();

        $output = ob_get_clean();
        $this->assertSame(json_encode($data), $output);
        $this->assertSame('application/json; charset=UTF-8', $response->header('Content-Type'));
    }

    public function testItCanRenderTemplate(): void
    {
        $response = Response::render('fixtures/sample_template', ['name' => 'John']);
        
        ob_start();
        $response->send();

        $output = ob_get_clean();
        $this->assertSame('Hello John', $output);
        $this->assertSame('text/html; charset=UTF-8', $response->header('Content-Type'));
    }

    public function testItThrowsExceptionWhenTemplateFileDoesNotExist(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('View file non_existent_template.php does not exist');

        Response::render('non_existent_template.php', []);
    }
}
