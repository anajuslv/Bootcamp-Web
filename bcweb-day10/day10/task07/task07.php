
<?php

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/chat.db');

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            sender TEXT NOT NULL,
            message TEXT NOT NULL
        )
    ");

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        $stmt = $pdo->query("
            SELECT sender, message
            FROM messages
            ORDER BY id ASC
        ");

        echo json_encode(
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );

        exit;
    }

    if ($method === 'POST') {
        $sender = trim($_POST['sender'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($sender === '' || $message === '') {
            http_response_code(400);

            echo json_encode([
                'error' => 'Name and message are required.'
            ]);

            exit;
        }

        if (mb_strlen($sender) > 100 ||
            mb_strlen($message) > 2000) {
            http_response_code(400);

            echo json_encode([
                'error' => 'The name or message is too long.'
            ]);

            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO messages (sender, message)
            VALUES (?, ?)
        ");

        $stmt->execute([$sender, $message]);

        echo json_encode([
            'success' => true
        ]);

        exit;
    }

    http_response_code(405);

    echo json_encode([
        'error' => 'Invalid request method.'
    ]);

} catch (Throwable $error) {
    http_response_code(500);

    echo json_encode([
        'error' => 'A server or database error occurred. Check the PHP terminal.'
    ]);
}
