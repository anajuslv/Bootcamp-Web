<?php
header('Content-Type: application/json; charset=utf-8');

function sendResponse(bool $success, string $message): void
{
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method.');
}

$type = trim($_POST['type'] ?? '');
$brand = trim($_POST['brand'] ?? '');
$price = trim($_POST['price'] ?? '');
$number = trim($_POST['number'] ?? '');

// Validate type
if (strlen($type) < 3 || strlen($type) > 10) {
    sendResponse(false, 'Type must contain between 3 and 10 characters.');
}

if (!preg_match('/^[a-zA-Z-]+$/', $type)) {
    sendResponse(false, "Type can only contain letters and hyphens.");
}

// Validate brand
if (strlen($brand) < 2 || strlen($brand) > 20) {
    sendResponse(false, 'Brand must contain between 2 and 20 characters.');
}

if (!preg_match('/^[a-zA-Z0-9&-]+$/', $brand)) {
    sendResponse(false, 'Brand contains invalid characters.');
}

// Validate price: zero and decimal values are allowed
if ($price === '' || !is_numeric($price) || (float)$price < 0) {
    sendResponse(false, 'Price must be a number greater than or equal to 0.');
}

// Validate stock: zero or a positive integer is allowed
if ($number === '' || !preg_match('/^[0-9]+$/', $number)) {
    sendResponse(false, 'Number must be a non-negative integer.');
}

$priceValue = (float)$price;
$stockValue = (int)$number;

try {
    $pdo = new PDO('sqlite:./ajax_products.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the product already exists
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM products
         WHERE LOWER(type) = LOWER(?)
         AND LOWER(brand) = LOWER(?)'
    );

    $stmt->execute([$type, $brand]);
    $exists = (int)$stmt->fetchColumn();

    if ($exists > 0) {
        // Update price and stock, including when either value is 0
        $stmt = $pdo->prepare(
            'UPDATE products
             SET price = ?, stock = ?
             WHERE LOWER(type) = LOWER(?)
             AND LOWER(brand) = LOWER(?)'
        );

        $stmt->execute([
            $priceValue,
            $stockValue,
            $type,
            $brand
        ]);

        sendResponse(
            true,
            "Product successfully updated: $type - $brand."
        );
    }

    // Insert a new product
    $stmt = $pdo->prepare(
        'INSERT INTO products (type, brand, price, stock)
         VALUES (?, ?, ?, ?)'
    );

    $stmt->execute([
        $type,
        $brand,
        $priceValue,
        $stockValue
    ]);

    sendResponse(
        true,
        "New product successfully inserted: $type - $brand."
    );

} catch (Throwable $e) {
    sendResponse(
        false,
        'Database error. Check the database path and table columns.'
    );
}
?>