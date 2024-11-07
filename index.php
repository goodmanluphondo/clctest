<?php

require_once __DIR__ . '/config.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $favourite_language = (int)$_POST['favourite_language'] ?? "";

    $query = "SELECT * FROM coding_languages WHERE id = :id LIMIT 1";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $favourite_language);
    $statement->execute();
    $lanuage = $statement->fetch(PDO::FETCH_ASSOC);

    if ($lanuage) {
        $user = \Helpers\Session::user();

        $query = "INSERT INTO votes (user_id, coding_language_id) VALUES (:user_id, :coding_language_id)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':user_id', $user->id);
        $statement->bindValue(':coding_language_id', $lanuage['id']);

        if ($statement->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "You have successfully voted!"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Something went wrong!"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Language not found."
        ]);
    }

    exit();
}

$user = \Helpers\Session::user();

if ($user->vote()) {
    header('Location: results.php');
    exit();
}

$coding_languages = \Models\CodingLanguage::getAll($pdo);

$assoc_coding_languages = [];
foreach ($coding_languages as $coding_language) {
    $assoc_coding_languages[$coding_language['id']] = $coding_language['name'];
}

echo \Helpers\Layout::component('index.template.php', ['coding_languages' => $assoc_coding_languages]);