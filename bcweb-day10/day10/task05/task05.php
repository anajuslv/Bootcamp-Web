<?php
header('Content-Type: application/json; charset=utf-8');

$type = trim($_GET['type'] ?? '');
$brand = trim($_GET['brand'] ?? '');
$price = trim($_GET['price'] ?? '');
$number = trim($_GET['number'] ?? '');

function sendError(string $message): void
{
    echo json_encode(['error' => $message]);
    exit;
}

// Validate type
if ($type === '') {
    sendError('Error (type): this type does not have enough characters.');
}

if (strlen($type) < 3) {
    sendError("Error ($type): this type does not have enough characters.");
}

if (strlen($type) > 10) {
    sendError("Error ($type): this type has too many characters.");
}

if (!preg_match('/^[a-zA-Z-]+$/', $type)) {
    sendError("Error ($type): this type has non-alphabetical characters (different from '-').");
}

// Validate brand
if ($brand === '') {
    sendError('Error (brand): this brand does not have enough characters.');
}

if (strlen($brand) < 2) {
    sendError("Error ($brand): this brand does not have enough characters.");
}

if (strlen($brand) > 20) {
    sendError("Error ($brand): this brand has too much characters.");
}

if (!preg_match('/^[a-zA-Z0-9&-]+$/', $brand)) {
    sendError("Error ($brand): this brand has invalid characters.");
}

// Validate price length
if (strlen($price) < 2) {
    sendError("Error ($price): this price does not have enough characters.");
}

if (strlen($price) > 5) {
    sendError("Error ($price): this price has too many characters.");
}

// Price must start with >, < or =, followed by digits
if (!preg_match('/^[><=][0-9]+$/', $price)) {
    sendError("Error ($price): we cannot define a price - string invalid.");
}

// Validate number: positive integer only
if (!preg_match('/^[0-9]+$/', $number) || (int)$number <= 0) {
    sendError("Error ($number): not a positive number.");
}

$requestedNumber = (int)$number;

// Connect to SQLite and search
try {
    $pdo = new PDO('sqlite:ajax_products.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check whether the type exists
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM products WHERE LOWER(type) = LOWER(?)'
    );
    $stmt->execute([$type]);

    if ((int)$stmt->fetchColumn() === 0) {
        sendError("Error ($type): this type doesn't exist in our shop.");
    }

    // Check whether the brand exists
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM products WHERE LOWER(brand) = LOWER(?)'
    );
    $stmt->execute([$brand]);

    if ((int)$stmt->fetchColumn() === 0) {
        sendError("Error ($brand): this brand doesn't exist in our database.");
    }

    // Separate the price operator from its numeric value
    $operator = $price[0];
    $priceValue = (int)substr($price, 1);

    // Consultar preços
    $sql = "SELECT type, brand, price, stock
            FROM products
            WHERE LOWER(type) = LOWER(?)
            AND LOWER(brand) = LOWER(?)
            AND price $operator ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$type, $brand, $priceValue]);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // retorno em array associativo

    if (count($products) === 0) {
        sendError("Error ($price): no products found at this price.");
    }

    // Check stock for every matching product
    foreach ($products as $product) {
        if ($requestedNumber > (int)$product['stock']) {
            $stock = $product['stock'];
            sendError(
                "Error ($number): sorry, we don't have enough stock, we only have $stock in stock."
            );
        }
    }

    // Add the requested quantity to each result
    $results = [];

    foreach ($products as $product) {
        $results[] = [
            'type' => $product['type'],
            'brand' => $product['brand'],
            'price' => $product['price'],
            'number' => $requestedNumber,
            'stock' => $product['stock']
        ];
    }

    echo json_encode($results);

} catch (Throwable $e) {
    sendError('Database error. Please check the database and table structure.');
}
?>