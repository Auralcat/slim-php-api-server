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
