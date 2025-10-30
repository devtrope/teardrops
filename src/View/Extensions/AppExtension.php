<?php

namespace App\View\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

/**
 * Custom Twig extension for application-specific functions and filters.
 * 
 * Add your own Twig functions and filters here.
 * 
 * @see https://twig.symfony.com/doc/3.x/advanced.html#creating-an-extension
 */
class AppExtension extends AbstractExtension
{
    /**
     * Register custom Twig functions.
     */
    public function getFunctions(): array
    {
        return [
            // new TwigFunction('formatDate', [$this, 'formatDate']),
        ];
    }

    /**
     * Register custom Twig filters.
     */
    public function getFilters(): array
    {
        return [
            // new TwigFilter('excerpt', [$this, 'excerpt']),
        ];
    }

    // Add your custom methods here
}
