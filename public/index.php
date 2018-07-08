<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require '../vendor/autoload.php';
require '../src/config/db.php';

// Enable basic logging
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/slimapp-logs/slimapp_error.log");
error_log("Hello Errors!");

date_default_timezone_set("America/Sao_Paulo");

$app = new \Slim\App();

// Testing a logging endpoint
$app->get('/simplelog', function(Request $request, Response $response) {
    // Info level
    $this->logger->write("This is an info level message from Logger class library", Silalahi\Slim\Logger::INFO);
    // Critical Level
    $this->logger->write("This is a critical level message from Logger class library", Silalahi\Slim\Logger::CRITICAL);
    // Debug level
    $this->logger->write("This is a debug level message from Logger class library", Silalahi\Slim\Logger::DEBUG);

    return $response->write("Hello, I'm a logging endpoint");
});

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
