<?php

declare (strict_types = 1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use MyApp\Service\DependencyContainer;
use MyApp\Routing\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../', '.env.local');
$dotenv->load();

$container = new DependencyContainer();
$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

// Add global session variables to Twig
$twig->addGlobal('session', $_SESSION);

$router = new Router($container);
$router->route($twig);
?>