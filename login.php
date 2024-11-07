<?php session_start();

require_once __DIR__ . '/config.php';

use Controllers\Authentication;
use Helpers\Layout;

if (isset($_SESSION['user'])) {
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $errorBag = [];

    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    $usernameQuery = "SELECT id, first_name, last_name, username, password FROM users WHERE username = :username LIMIT 1";
    $statement = $pdo->prepare($usernameQuery);
    $statement->bindParam(':username', $username);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']);
        $_SESSION['user'] = new \Models\User(...$user);
        echo json_encode([
            "success" => true,
            "message" => "You have successfully logged in!",
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid username or password!",
        ]);
    }

    exit();
}

echo Layout::component('login.template.php');

