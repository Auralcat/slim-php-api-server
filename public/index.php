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

$app = new \Slim\App();

/* Call the objects in the client using host/slimapp/index.php/hello/whatever */
$app->get('/hello/{name}', function(Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

// Customer Routes
require '../src/routes/customers.php';

$app->run();
?>
