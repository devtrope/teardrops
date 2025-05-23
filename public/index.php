<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Ludens\Builder\Application;

Application::setup(baseDirectory: dirname(__DIR__))->run();