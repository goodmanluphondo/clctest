<?php

require_once __DIR__ . '/config.php';

$users = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

// SQL to create coding_languages table
$codingLanguages = "
CREATE TABLE IF NOT EXISTS coding_languages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

$votes = "
CREATE TABLE IF NOT EXISTS votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    coding_language_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (coding_language_id) REFERENCES coding_languages(id)
);";

$languages = ['PHP', 'C#', 'C', 'JAVA', 'Python', 'C++'];

try {
    global $pdo;

    $pdo->exec($users);

    $pdo->exec($codingLanguages);

    $query = "INSERT INTO coding_languages (name) VALUES (:name)";
    $statement = $pdo->prepare($query);
    foreach ($languages as $language) {
        $statement->bindParam(':name', $language);
        $statement->execute();
    }

    $pdo->exec($votes);

    echo "Setup completed.\n";
} catch (PDOException $e) {
    die("Error creating tables: {$e->getMessage()}");
}