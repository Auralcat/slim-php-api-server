<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require '../vendor/autoload.php';
require '../src/config/db.php';

/* Call the objects in the client using host/slimapp/index.php/hello/whatever */
$app = new \Slim\App;

// Create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('../logs/error.log', Logger::WARNING));

// Add records to the log
$log->warning('Foo');
$log->error('Bar');

$app->get('/hello/{name}', function(Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

// Customer Routes
require '../src/routes/customers.php';

$app->run();
?>
