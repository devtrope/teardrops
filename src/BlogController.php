<?php

namespace Teardrops\Teardrops;

class BlogController
{
    public function index(): void
    {
        echo 'Welcome to the Blog!';
    }

    public function show(string $slug): void
    {
        echo "Displaying blog post: " . htmlspecialchars($slug);
    }

    public function add(Request $request, int $id): void
    {
        echo 'Blog post added with method : ' . $request->getMethod() . ' and ID: ' . intval($id);
    }
}
