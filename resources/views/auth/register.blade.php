<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Xgenious Task</title>
    <link rel=icon href="favicons.png" sizes="16x16" type="icon/png">
    @include('layouts.style')
    <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">
    <!-- dark css -->
</head>

<body>
    <!--login Area start-->
    <section class="loginForm">
        <div class="loginForm__flex">
            <div class="loginForm__left">
                <div class="loginForm__left__inner desktop-center">
                    <div class="loginForm__header">
                        <h2 class="loginForm__header__title">Welcome Back</h2>
                        <p class="loginForm__header__para mt-3">Login with your data that you entered during
                            registration.</p>
                    </div>
                    <div class="loginForm__wrapper mt-4">
                        <form class="custom_form">
                            <div class="single_input">
                                <label class="label_title">Name</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="text" id="name"
                                        placeholder="Enter your Full Name">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">person</span>
                                    </div>
                                </div>
                                <span id="showErrorName" class="text-danger"></span>
                            </div>
                            <div class="single_input">
                                <label class="label_title">Username</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="text" id="username"
                                        placeholder="Enter your username">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">mail</span>
                                    </div>
                                </div>
                                <span id="showErrorUsername" class="text-danger"></span>
                            </div>
                            <div class="single_input">
                                <label class="label_title">Email</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="email" id="email"
                                        placeholder="Enter your email address">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">mail</span>
                                    </div>
                                </div>
                                <span id="showErrorEmail" class="text-danger"></span>
                            </div>
                            <div class="single_input">
                                <label class="label_title">Password</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="password" id="password"
                                        placeholder="Enter your password">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">lock</span>
                                    </div>
                                </div>
                                <span id="showErrorPassword" class="text-danger"></span>
                            </div>
                            <div class="single_input">
                                <label class="label_title">Confirm Password</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="password" id="confirm_password"
                                        placeholder="confirm password">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">lock</span>
                                    </div>
                                </div>
                                <span id="showErrorConfirmPassword" class="text-danger"></span>
                                <span id="showSuccessConfirmPassword" class="text-success"></span>
                            </div>
                            <div class="btn_wrapper single_input">
                                <button type="submit" class="cmn_btn w-100 radius-5">
                                    Sign Up
                                </button>
                            </div>
                            <div class="btn-wrapper mt-4">
                                <p class="loginForm__wrapper__signup"><span>
                                        Already have an Account?
                                    </span>
                                    <a href="{{ route('login') }}" class="loginForm__wrapper__signup__btn">
                                        Sign In
                                    </a>
                                </p>
                                <div class="loginForm__wrapper__another d-flex flex-column gap-2 mt-3">
                                    <a href="javascript:void(0)"
                                        class="loginForm__wrapper__another__btn radius-5 w-100">
                                        <img src="{{ asset('assets/img/icon/googleIocn.svg') }}" alt=""
                                            class="icon">
                                        Login With Google
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="loginForm__wrapper__another__btn radius-5 w-100">
                                        <img src="{{ asset('assets/img/icon/googleIocn.svg') }}" alt=""
                                            class="icon">
                                        Login With Facebook
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="loginForm__right loginForm__bg " style="background-image: url(assets/img/login.jpg);">
                <div class="loginForm__right__logo">
                    <div class="loginForm__logo">
                        <a href="index.html">
                            <img src="{{ asset('assets/img/logo.webp') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login Area end -->
    @include('layouts.script')
    <script src="{{ asset('toastr/toastr.js') }}"></script>
    {!! Toastr::message() !!}

    <script>
        function checkPasswordMatch() {
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();
            const errorSpan = $('#showErrorConfirmPassword');

            if (confirmPassword === password) {
                errorSpan.text("Passwords match!");
                errorSpan.removeClass("text-danger").addClass("text-success");
            } else {
                errorSpan.text("Passwords do not match!");
                errorSpan.removeClass("text-success").addClass("text-danger");
            }
        }
        $('#confirm_password').on('input', checkPasswordMatch);
        $('#password').on('input', checkPasswordMatch);
    </script>

    <script>
        $(document).ready(function() {
            $('.custom_form').on('submit', function(e) {
                e.preventDefault();

                let name = $('#name').val();
                let username = $('#username').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let confirm_password = $('#confirm_password').val();

                $.ajax({
                    url: "{{ route('register.user') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: name,
                        username: username,
                        email: email,
                        password: password,
                        password_confirmation: confirm_password,
                    },
                    success: function(response) {
                        if (response.status == true) {
                            toastr.success(response.message);
                            window.location.href = response.route;
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(error) {
                        let errors = error.responseJSON.errors;
                        if (errors) {
                            if (errors.name) {
                                $('#showErrorName').text(errors.name[0]);
                            }
                            if (errors.email) {
                                $('#showErrorEmail').text(errors.email[0]);
                            }
                            if (errors.password) {
                                $('#showErrorPassword').text(errors.password[0]);
                            }
                            if (errors.username) {
                                $('#showErrorUsername').text(errors.username[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>
