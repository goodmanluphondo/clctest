<?php
session_start();

require_once __DIR__ . '/config.php';

if (isset($_SESSION['user'])) {
    header('Location: /');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptchaToken = $_POST['g-recaptcha-response'];
    $secretKey = RECAPTCHA_SECRET_KEY;

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaToken");
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        echo json_encode([
            'success' => false,
            'message' => 'reCAPTCHA verification failed.'
        ]);

        exit();
    }

    global $pdo;

    $errorBag = [];

    $first_name = $_POST["first_name"] ?? "";
    $last_name = $_POST["last_name"] ?? "";
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $errorBag["username"] = "Username already exists.";
        echo json_encode([
            "success" => false,
            "message" => "Username already exists.",
            "data" => $errorBag
        ]);

        exit();
    }

    $hashed_password = password_hash("Password!", PASSWORD_BCRYPT, array("cost" => 12));

    $query = "INSERT INTO users (first_name, last_name, username, password) VALUES (:first_name, :last_name, :username, :password)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);

    if ($stmt->execute()) {
        $id = $pdo->lastInsertId();
        $_SESSION['user'] = new \Models\User($id, $first_name, $last_name, $username);
        echo json_encode([
            "success" => true,
            "message" => "User created successfully.",
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Something went wrong.",
        ]);
    }

    exit();
}

echo \Helpers\Layout::component('register.template.php');