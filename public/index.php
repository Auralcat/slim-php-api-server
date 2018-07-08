<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

/* Call the objects in the client using host/slimapp/index.php/hello/whatever */
$app = new \Slim\App;
$app->get('/hello/{name}', function(Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

// Customer Routes
require '../src/routes/customers.php';

$app->run();
?>
