<?php
$attributes = "type=\"" . (isset($type) ? $type : 'button') . "\"";
$my_classes = "py-2 px-3 inline-flex space-x-2 justify-center cursor-pointer rounded-lg text-white bg-primary hover:bg-primary/80";

if (isset($id)) {
    $attributes .= " id='" . $id . "'";
}

if (isset($onclick)) {
    $attributes .= " onclick='" . $onclick . "'";
}

if (isset($style)) {
    $attributes .= " style='" . $style . "'";
}

if (isset($class)) {
    $customClasses = explode(" ", $my_classes);
    $importClasses = explode(" ", $class);

    $class = implode(" ", array_unique(array_merge($customClasses, $importClasses)));
    $attributes .= " class='" . $class . "'";
} else {
    $attributes .= " class='" . $my_classes . "'";
}
?>
<button <?= $attributes ?>>
    <span id="spinner" class="w-6 h-6 hidden border-4 border-blue-500 border-t-transparent border-solid rounded-full animate-spin"></span>
    <span><?= isset($label) ? $label : '' ?></span>
</button><?= PHP_EOL ?>