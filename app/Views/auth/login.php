<?php
$pageTitle = 'Login';
ob_start();
?>
<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="card px-4 py-4" style="width: 400px; height: 350px">
        <form class="">

            <div class="text-danger error_text mt-1" id="invalid-error" style="visibility: hidden;">Invalid email or password</div>

            <div data-mdb-input-init class="form-outline">
                <label class="form-label" for="login_email_address">Email address</label>
                <input type="email" id="login_email_address" class="form-control" />
                <div class="text-danger error_text mt-1" id="login-email-error" style="visibility: hidden;">error</div>
            </div>

            <div data-mdb-input-init class="form-outline">
                <label class="form-label" for="login_password">Password</label>
                <input type="password" id="login_password" class="form-control" />
                <div class="text-danger error_text mt-1" id="login-password-error" style="visibility: hidden;">error</div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-primary bg-primary" id="login-loading-message" disabled style="display: none;">Loading...</button>
                <button id="sign_in_button" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign in</button>
            </div>

            <div class="text-center d-flex justify-content-center gap-4">
                <p>For a member? <a href="/register">Sign up</a></p>
                <p>or sign in with:</p>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include_once __DIR__ . '/auth.php';
?>

<script>
    $(document).ready(function() {
        $('#sign_in_button').on('click', function() {
            const formData = new FormData();
            formData.append('email', $('#login_email_address').val());
            formData.append('password', $('#login_password').val());

            const $loginLoadingMessage = $('#login-loading-message');
            const $signInButton = $('#sign_in_button');
            $signInButton.hide();
            $loginLoadingMessage.show();

            $("#login-email-error, #login-password-error, #invalid-error").css({ visibility: 'hidden' });

            $.ajax({
                url: '/sign_in',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }
                    if (response.success) {
                        setTimeout(() => {
                            $loginLoadingMessage.hide();
                            alert(response.message);
                            window.location.href = '/';
                        }, 1000);
                    } else {
                        $signInButton.show();
                        $loginLoadingMessage.hide();

                        if (response.errors) {
                            if (response.errors.email) {
                                $('#login-email-error').text(response.errors.email).css({ visibility: 'visible' });
                            }
                            if (response.errors.password) {
                                $('#login-password-error').text(response.errors.password).css({ visibility: 'visible' });
                            }
                        } else {
                            $("#invalid-error").css({ visibility: 'visible' }).text(response.message);
                            setTimeout(() => {
                                $loginLoadingMessage.hide();
                            }, 1000);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Login failed:', xhr.responseText);
                    alert('Login failed. Please try again.');
                }
            });
        });
    });
</script>
