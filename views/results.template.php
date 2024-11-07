<?php

use Helpers\Layout;

?>
<!doctype html>
<html lang="en">
<?= Layout::component('shared/head.template.php', ['title' => 'Results']); ?>
<body>
<div class="min-h-screen flex items-center justify-center bg-primary relative">
    <div class="absolute top-10 right-10">
        <a href="logout.php" class="py-2 px-4 text-primary rounded-full bg-secondary">Logout</a>
    </div>
    <div class="w-full max-w-[450px] text-tertiary space-y-8 p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl text-center font-bold">Poll Results</h1>
        <?= Layout::component('components/results.template.php', ['results' => $results]); ?>
    </div>
</div>
</body>
</html>