<?php
header('Content-Type: application/json');

$type = isset($_GET['type']) ? trim($_GET['type']) : '';
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';

$typeValid = false;
$brandValid = false;
$typeMessage = "";
$brandMessage = "";

// Conexão SQLite
try {
    $pdo = new PDO('sqlite:ajax_products.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Validação do Type
if ($type === '') {
    $typeMessage = "No type sent yet!";
} elseif (strlen($type) < 3) {
    $typeMessage = "$type: this type does not have enough characters.";
} elseif (strlen($type) > 10) {
    $typeMessage = "$type: this type has too many characters.";
} elseif (!preg_match('/^[a-zA-Z-]+$/', $type)) {
    $typeMessage = "$type: this type has non-alphabetical characters (different from '-').";
} else {
    // Checar se existe no BD
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE LOWER(type) = LOWER(?)");
    $stmt->execute([$type]);
    $exists = $stmt->fetchColumn();

    if ($exists == 0) {
        $typeMessage = "$type: this type doesn't exist in our shop.";
    } else {
        $typeValid = true;
        $typeMessage = "$type: this type exists in databases.";
    }
}

// Validação do Brand
if ($brand === '') {
    $brandMessage = "No brand sent yet!";
} elseif (strlen($brand) < 2) {
    $brandMessage = "$brand: this brand does not have enough characters.";
} elseif (strlen($brand) > 20) {
    $brandMessage = "$brand: this brand has too many characters.";
} elseif (!preg_match('/^[a-zA-Z0-9&-]+$/', $brand)) {
    $brandMessage = "$brand: this brand has invalid characters.";
} else {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE LOWER(brand) = LOWER(?)");
    $stmt->execute([$brand]);
    $existsBrand = $stmt->fetchColumn();

    if ($existsBrand > 0) {
        $brandMessage = "$brand: this brand already exists in databases.";
    } else {
        $brandValid = true;
        $brandMessage = "$brand: this brand is valid for the type $type.";
    }
}

echo json_encode([
    'typeValid' => $typeValid,
    'typeMessage' => $typeMessage,
    'brandValid' => $brandValid,
    'brandMessage' => $brandMessage
]);
?>