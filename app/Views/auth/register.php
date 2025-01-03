<?php
$pageTitle = 'Register';
ob_start();
?>
<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="card h-50 px-4 py-5" style="width: 400px;" >
        <form class="">

            <div data-mdb-input-init class="form-outline">
                <label class="form-label" for="user_name">User name</label>
                <input type="email" id="user_name" class="form-control" />
                <div class="text-danger error_text mt-1" id="username-error" style="visibility: hidden;">error</div>
            </div>

            <div data-mdb-input-init class="form-outline">
                <label class="form-label" for="email_address">Email address</label>
                <input type="email" id="email_address" class="form-control" />
                <div class="text-danger error_text mt-1" id="email-error" style="visibility: hidden;">error</div>
            </div>

            <div data-mdb-input-init class="form-outline">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" class="form-control" />
                <div class="text-danger error_text mt-1" id="password-error" style="visibility: hidden;">error</div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-primary bg-primary" id="register-loading-message" disabled style="display: none;">Loading...</button>
                <button id="sign_up_button" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign up</button>
            </div>

            <div class="text-center d-flex justify-content-center gap-4">
                <p>For a member? <a href="/login">Login</a></p>
                <p>or sign up with:</p>
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
        $('#sign_up_button').on('click', function() {
            const formData = new FormData();
            formData.append('username', $('#user_name').val());
            formData.append('email', $('#email_address').val());
            formData.append('password', $('#password').val());

            const $registerLoadingMessage = $('#register-loading-message');
            const $signUpButton = $('#sign_up_button');
            $signUpButton.hide();
            $registerLoadingMessage.show();

            $.ajax({
                url: '/sign_up',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }
                    if (response.success) {
                        console.log(response);
                        alert(response.message);
                        window.location.href = '/login';

                        setTimeout(() => {
                            $registerLoadingMessage.hide();
                            alert(response.message);
                            window.location.href = '/login';
                        }, 1000);

                    } else {
                        $signUpButton.show();
                        $registerLoadingMessage.hide();
                        if (response.errors) {

                            if (response.errors.username) {
                                $('#username-error').text(response.errors.username).css({ visibility: 'visible' });
                            }
                            if (response.errors.email) {
                                $('#email-error').text(response.errors.email).css({ visibility: 'visible' });
                            }
                            if (response.errors.password) {
                                $('#password-error').text(response.errors.password).css({ visibility: 'visible' });
                            }
                        } else {
                            setTimeout(() => {
                                $registerLoadingMessage.hide();
                            }, 1000);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Registration failed:', xhr.responseText);
                    alert('Registration failed. Please try again.');
                }
            });
        });
    });
</script>
