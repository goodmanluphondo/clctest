<?php
$attributes = "type=\"" . (isset($type) ? $type : 'text') . "\"";

if (isset($id)) {
    $attributes .= " id='" . $id . "'";
}

if (isset($name)) {
    $attributes .= " name='" . $name . "'";
}

if (isset($placeholder)) {
    $attributes .= " placeholder='" . $placeholder . "'";
}

if (isset($value)) {
    $attributes .= " value='" . $value . "'";
}

if (isset($style)) {
    $attributes .= " style='" . $style . "'";
}
?>
<label class="flex flex-col gap-2 font-bold">
    <?= isset($label) ? $label."\n" : ''; ?>
    <input <?= $attributes ?> class="w-full py-2 px-3 rounded-lg border border-tertiary/50" />
</label><?= "\n" ?>