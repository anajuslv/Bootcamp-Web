<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(200);
        echo "Valid email";
    } else {
        http_response_code(400);
        echo "Invalid email";
    }
} else {
    http_response_code(400);
    echo "Bad request";
}
?>