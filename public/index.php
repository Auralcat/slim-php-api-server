<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require '../vendor/autoload.php';
require '../src/config/db.php';

// Enable basic logging
date_default_timezone_set("America/Sao_Paulo");
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
error_log("This is a sample error message.");

// Enable CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Should do a check here to match $_SERVER{['HTTP_ORIGIN']} to a whitelist
    // of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 86400"); // Cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
}
$app = new \Slim\App();

// Twig view integration starts here............................................
$container = $app->getContainer();

// Register Twig View helper in app dependency injection container
$container['view'] = function($c) {
    $view = new \Slim\Views\Twig('../views/', [
        'cache' => '/tmp/cache/'
    ]);

    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

// Define named route
$app->get('/hello/{name}', function(Request $request, Response $response, $args) {
    return $this->view->render($response, 'profile.html', [
        'name' => $args['name']
    ]);
})->setName('profile');

// Creating a main view for the project
$app->get('/main', function(Request $request, Response $response, $args) {
    return $this->view->render($response, 'main.html', [

    ]);
})->setName('main');

// Render from string
$app->get('/hi/{name}', function(Request $request, Response $response, $args) {
    $str = $this->view->fetchFromString('<p>Hi, my name is {{ name }}.</p>', [
        'name' => $args['name']
    ]);
    $response->getBody()->write($str);
    return $response;
});

// Twig view integration ends here..............................................

// Customer Routes
require '../src/routes/customers.php';

$app->run();
?>
