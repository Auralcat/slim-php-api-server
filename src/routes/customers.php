<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Get All Customers
$app->get('/api/customers', function(Request $request, Response $response) {
    $sql = "SELECT * FROM customers";
    try
    {
        // Get DB object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        // Return the result as a JSON array.
        echo json_encode($customers);
    } catch(PDOException $e)
    {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});

// Get single customer
$app->get('/api/customer/{id}', function(Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM customers WHERE id = $id";
    try
    {
        // Get DB object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        // Return the result as a JSON array.
        echo json_encode($customer);
    } catch(PDOException $e)
    {
        echo '{"error": {"text": ' . $e->getMessage() . '}';
    }
});
?>
