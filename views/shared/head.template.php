<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title : APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#023575',
                        secondary: '#FFE100',
                        tertiary: '#6c757d',
                    }
                }
            }
        }
    </script>
</head><?= PHP_EOL ?>