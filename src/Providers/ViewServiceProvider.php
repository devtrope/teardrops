<?php

namespace App\Providers;

use App\View\Extensions\AppExtension;
use Ludens\Framework\View\ViewRenderer;
use Ludens\Support\ServiceProvider;

/**
 * Provide custom extensions to the templates.
 */
class ViewServiceProvider implements ServiceProvider
{
    public function boot(): void
    {
        ViewRenderer::getInstance()->addExtension(
            new AppExtension()
        );
    }
}