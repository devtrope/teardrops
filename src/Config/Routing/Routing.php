<?php

namespace Teardrops\Teardrops\Config\Routing;

use Teardrops\Teardrops\Config\Config;

class Routing
{
    protected ?string $controller;
    protected string $method = Config::DEFAULT_METHOD;
    protected array $params = [];
}
