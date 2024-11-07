<?php

session_start();

require_once __DIR__ . '/config.php';

if (isset($_SESSION['user'])) {
    session_unset();
    setcookie(session_name(), '');
    session_destroy();
    $_SESSION = array();
}

header('Location: index.template.php');
exit;