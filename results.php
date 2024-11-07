<?php
session_start();

require_once __DIR__ . '/config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.template.php');
    exit();
}
global $pdo;

$results = \Models\Vote::tally($pdo);

echo \Helpers\Layout::component('results.template.php', ['results' => $results]);