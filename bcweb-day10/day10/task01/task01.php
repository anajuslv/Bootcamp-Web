<?php
header('Content-Type: application/json');

$name = isset($_GET['name']) ? $_GET['name'] : '';
echo json_encode(['name' => $name]);
?>