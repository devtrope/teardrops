<?php

require_once dirname(__DIR__) . '../vendor/autoload.php';

use Teardrops\Teardrops\Application;

Application::setup(baseDir: dirname(__DIR__))->run();