# Teardrops

Teardrops is a lightweight PHP micro-framework built for developers who want full control while enjoying a clean, modern structure inspired by larger frameworks.

## Installation

Create a new project using Composer:

```bash
composer create-project teardrops/teardrops my-project
```

## Getting Started

Start a local development server:

```bash
php -s localhost:8000 -t public
```

The entry point of the application is located in the `public/` directory.

## Project structure

```
my-project/
├── app/                  # Controllers, services, etc.
│   └── Http/
│       └── Controllers/
├── public/               # Public-facing directory (index.php)
├── routes/               # Route definitions
├── storage/              # Cache, logs, temporary files
├── view/                 # Twig templates
└── src/                  # Core framework files
```

## Features

- Simple HTTP method-based routing
- Dependency injection (via PHP-DI)
- Clean exception handling
- Built-in Twig template engine
- Minimal and intuitive MVC structure

## Coming Soon

- Middleware support
- Artisan-style CLI commands
- Migrations