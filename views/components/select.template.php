<?php
$attributes = "";

if (isset($id)) {
    $attributes .= " id='" . $id . "'";
}

if (isset($style)) {
    $attributes .= " style='" . $style . "'";
}
?>
<label class="flex flex-col gap-2">
    <?= isset($label) ? $label."\n" : ''; ?>
    <select <?= $attributes ?> class="w-full py-2 px-3 border border-tertiary/50 rounded-lg bg-white">
        <option value>Select One</option>
        <?php
        if (!empty($options)) {
            echo "\n";
            foreach ($options as $key => $value) {
                echo '<option value="'.$key.'">'.$value.'</option>';
            }
        }
        ?>
    </select>
</label>
