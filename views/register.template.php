<?php

use Helpers\Layout;

?>
<!doctype html>
<html lang="en">
<?= Layout::component('shared/head.template.php', ['title' => 'Register']); ?>
<body>
<div class="min-h-screen flex items-center justify-center bg-primary">
    <div class="w-full max-w-[450px] text-tertiary space-y-8 p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl text-center font-bold">Create an account to start voting!</h1>
        <p id="status" class="text-red-500"></p>
        <form>
            <div class="mb-4">
                <?= Layout::component('components/input.template.php', ['label' => 'First name', 'id' => 'first_name']) ?>
                <div id="first_name-errors" class="mt-2 text-sm text-red-500"></div>
            </div>
            <div class="mb-4">
                <?= Layout::component('components/input.template.php', ['label' => 'Last name', 'id' => 'last_name']) ?>
                <div id="last_name-errors" class="mt-2 text-sm text-red-500"></div>
            </div>
            <div class="mb-4">
                <?= Layout::component('components/input.template.php', ['label' => 'Username', 'id' => 'username', 'type' => 'email']) ?>
                <div id="username-errors" class="mt-2 text-sm text-red-500"></div>
            </div>
            <div class="mb-4">
                <?= Layout::component('components/input.template.php', ['label' => 'Password', 'id' => 'password', 'type' => 'password']) ?>
                <div id="password-errors" class="mt-2 text-sm text-red-500"></div>
            </div>
            <div class="g-recaptcha" data-sitekey="<?= RECAPTCHA_SITE_KEY ?>" data-callback="onReCaptchaSuccess" data-size="invisible"></div>
        </form>
        <div>
            <?= Layout::component('components/button.template.php', ['label' => 'Register', 'class' => 'w-full', 'onclick' => 'register()']) ?>
        </div>
        <div class="text-center">
            <p>Already have an account? <a href="login.php" class="text-primary">Login</a></p>
        </div>
    </div>
</div>
<?= Layout::component('shared/scripts.template.php'); ?>
<script>
    function register() {
        clearErrorContainers();

        let errors = [];

        let first_name = $('#first_name').val().trim();
        let username   = $('#username').val().trim();
        let password   = $('#password').val().trim();

        if (first_name === "") {
            errors.push({first_name: 'First name is required'});
        }

        if (username === "") {
            errors.push({username: 'Username is required'});
        }

        if (username.length < 5) {
            errors.push({username: 'Username must be at least 5 characters'});
        }

        if (/[^a-zA-Z0-9]/.test(username)) {
            errors.push({username: 'Username must not contain spaces or special characters'});
        }

        if (password === "") {
            errors.push({password: 'Password is required'});
        }

        if (password.length < 8) {
            errors.push({password: 'Password must be at least 8 characters'});
        }

        if (!/[A-Z]/.test(password)) {
            errors.push({password: 'Password must have at least one uppercase character'});
        }

        if (!/[!@#$%^&*(),?":{}|<>]/.test(password)) {
            errors.push({password: 'Password must have at least one special character'});
        }

        let errorBag = buildErrorBag(errors);

        if (Object.keys(errorBag).length > 0) {
            for(let error in errorBag) {
                const ul = document.createElement("ul");
                errorBag[error].forEach(errorMessage => {
                    const li = document.createElement("li");
                    li.textContent = errorMessage;
                    ul.appendChild(li);
                });
                document.getElementById(`${error}-errors`).appendChild(ul);
            }

            $(`#${Object.keys(errorBag)[0]}`).focus();

            return;
        }

        grecaptcha.execute();
    }

    function clearErrorContainers() {
        $('#status').text("");
        $('#first_name-errors').html("");
        $('#username-errors').html("");
        $('#password-errors').html("");
    }

    function onReCaptchaSuccess(token) {
        let first_name = $('#first_name').val().trim();
        let last_name  = $('#last_name').val().trim();
        let username   = $('#username').val().trim();
        let password   = $('#password').val().trim();

        $.ajax({
            type: 'POST',
            url: 'register.php',
            data: {
                first_name: first_name,
                last_name: last_name,
                username: username,
                password: password,
                'g-recaptcha-response': token
            },
            cache: false,
            beforeSend: () => {
                $('#spinner').toggleClass("hidden");
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success === true) {
                    window.location.replace("/");
                } else {
                    $('#status').text(response.message);
                }
            },
            complete: () => {
                $('#spinner').toggleClass("hidden");
            }
        })
    }
</script>
</body>
</html>
