<?php

error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("display_errors", "On");
ini_set("error_log", "logs/error.log");

define('APP_URL', 'https://clctest.goodmanmade.me');
define('APP_NAME', 'CLC Test');

define('METADATA_TITLE', 'CLC Test');
define('METADATA_CONTENT', 'CLC Test');
define('METADATA_DESCRIPTION', 'CLC Test');

define('DB_CONNECTION', 'mysql');
define('DB_HOST', 'kf3k4aywsrp0d2is.cbetxkdyhwsb.us-east-1.rds.amazonaws.com');
define('DB_DATABASE', 'ydonc5vq505z74c2');
define('DB_USERNAME', 'q38kvgujl2jic7ra');
define('DB_PASSWORD', 'j8dl82gbyptoen1m');

define('RECAPTCHA_SITE_KEY', '6LfRSXcqAAAAAJUJ5qJtIX7xgKwa76zuhCi61VPa');
define('RECAPTCHA_SECRET_KEY', '6LfRSXcqAAAAALvtPyDsYP9PIRV1yNX1f2JdAdQ-');

require_once __DIR__ . '/pdo.php';

spl_autoload_register(function ($class) {
    $directories = ['Helpers', 'Models'];

    foreach ($directories as $directory) {
        $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});