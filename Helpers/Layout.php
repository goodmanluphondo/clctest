<?php

namespace Helpers;

class Layout
{
    public static function component($template, $data = [])
    {
        if (!empty($data)) extract($data);

        ob_start();

        $file_path = __DIR__ . '/../views/' . $template;

        if (file_exists($file_path)) {
            include $file_path;
        } else {
            error_log("Template $template not found");
        }

        return ob_get_clean();
    }
}
