<?php

declare(strict_types=1);

use App\Core\App;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

define('ROOT_PATH', dirname(__DIR__));
define('NO_LAYOUT', 'false');

if (file_exists('.env')) {
    (new Dotenv())->load('.env');
}

App::init();
App::$kernel->handle();
