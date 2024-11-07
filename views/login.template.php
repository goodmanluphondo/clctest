<?php use Helpers\Layout; ?>
<!doctype html>
<html lang="en">
<?= Layout::component('shared/head.template.php', ['title' => 'Login']) ?>
<body>
<div class="min-h-screen flex items-center justify-center bg-primary">
    <div class="w-full max-w-[450px] text-tertiary space-y-8 p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl text-center font-bold">Log into the Real-world Polling Website!</h1>
        <p id="status" class="text-red-500"></p>
        <form>
            <div class="mb-4">
                <?= Layout::component('components/input.template.php', ['label' => 'Username', 'id' => 'username']) ?>
                <span id="username-errors" class="text-sm text-red-500"></span>
            </div>
            <div class="mb-4">
                <?= Layout::component('components/input.template.php', ['label' => 'Password', 'id' => 'password', 'type' => 'password']) ?>
                <span id="password-errors" class="text-sm text-red-500"></span>
            </div>
            <div class="g-recaptcha" data-sitekey="<?= RECAPTCHA_SITE_KEY ?>" data-callback="onReCaptchaSuccess" data-size="invisible"></div>
        </form>
        <div>
            <?= Layout::component('components/button.template.php', ['label' => 'Login', 'class' => 'w-full', 'onclick' => 'login()']) ?>
        </div>
        <div class="text-center">
            <p>Do not have an account? <a href="register.php" class="text-primary">Register</a></p>
        </div>
    </div>
</div>
<?= Layout::component('shared/scripts.template.php') ?>
<script>
    function login() {
        clearErrorContainers();

        let errors = [];

        let username = $('#username').val().trim();
        let password = $('#password').val().trim();

        if (username === "") {
            errors.push({username: 'Username is required'});
        }

        if (password === "") {
            errors.push({password: 'Password is required'});
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
        $('#username-errors').html("");
        $('#password-errors').html("");
    }

    function onReCaptchaSuccess(token) {
        let username = $('#username').val().trim();
        let password = $('#password').val().trim();

        $.ajax({
            type: 'POST',
            url: '/login.php',
            data: {username: username, password: password, 'g-recaptcha-response': token},
            beforeSend: () => {
                $('#spinner').toggleClass("hidden");
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    window.location.replace("/");
                } else {
                    $('#status').text(response.message);
                }
            },
            complete: () => {
                $('#spinner').toggleClass("hidden");
            }
        });
    }

    function onClick(e) {
        e.preventDefault();
        grecaptcha.enterprise.ready(async () => {
            const token = await grecaptcha.enterprise.execute('6Ld5JncqAAAAAEdgyuJ9xkWsypd-ykMMmEWQPnT5', {action: 'REGISTER'});
        });
    }
</script>
</body>
</html>
