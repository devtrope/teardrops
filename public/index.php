<?php

require_once dirname(__DIR__) . '../vendor/autoload.php';

use Teardrops\Teardrops\Kernel\Kernel;
use Teardrops\Teardrops\Kernel\Request;

$kernel = new Kernel();
$kernel->handle(new Request());