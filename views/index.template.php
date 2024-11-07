<?php

use Helpers\Layout;

?>
<!doctype html>
<html lang="en">
<?= Layout::component('shared/head.template.php'); ?>
<body>
<div class="min-h-screen flex items-center justify-center bg-primary relative">
    <div class="absolute top-10 right-10">
        <a href="logout.php" class="py-2 px-4 text-primary rounded-full bg-secondary">Logout</a>
    </div>
    <div class="w-full max-w-[450px] text-tertiary space-y-8 p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl text-center font-bold">Welcome to the Real-world Polling Website!</h1>
        <p id="status" class="text-red-500"></p>
        <form>
            <div>
                <?= Layout::component('components/select.template.php', ['options' => $coding_languages, 'label' => 'What is your favourite coding language?', 'id' => 'favourite_language']); ?>
            </div>
        </form>
        <div>
            <?= Layout::component('components/button.template.php', ['label' => 'Vote', 'class' => 'w-full', 'onclick' => 'vote()']); ?>
        </div>
    </div>
</div>
<?= Layout::component('shared/scripts.template.php'); ?>
<script>
    function vote() {
        let errors = [];

        let favourite_language = $('#favourite_language').val();

        if (favourite_language === "") {
            errors.push({favourite_language: 'Favourite coding language is required.'});
        }

        let errorBag = buildErrorBag(errors);

        if (Object.keys(errorBag).length > 0) {
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/',
            data: {favourite_language: favourite_language},
            beforeSend: function() {
                $('#status').text("");
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    window.location.replace("results.php");
                } else {
                    $('#status').text(response.message);
                }
            }
        })
    }
</script>
</body>
</html>