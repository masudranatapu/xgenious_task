<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Xgenious Task</title>
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
                        <h2 class="loginForm__header__title">
                            Welcome Back
                        </h2>
                        <p class="loginForm__header__para mt-3">
                            Login with your data that you entered during registration.
                        </p>
                    </div>
                    <div class="loginForm__wrapper mt-4">
                        <form class="custom_form">
                            <div class="single_input">
                                <label class="label_title">Username or Email</label>
                                <div class="include_icon">
                                    <input type="text" id="username_email" class="form-control"
                                        placeholder="Enter your email or username">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">mail</span>
                                    </div>
                                </div>
                                <span id="showErrorEmail" class="text-danger"></span>
                            </div>
                            <div class="single_input">
                                <label class="label_title">Password</label>
                                <div class="include_icon">
                                    <input id="password" class="form--control radius-5" type="password"
                                        placeholder="Enter your password">
                                    <div class="icon">
                                        <span class="material-symbols-outlined">lock</span>
                                    </div>
                                </div>
                                <span id="showErrorPassword" class="text-danger"></span>
                            </div>
                            <div class="loginForm__wrapper__remember single_input">
                                <div class="dashboard_checkBox">
                                    <input class="dashboard_checkBox__input" id="remember" type="checkbox">
                                    <label class="dashboard_checkBox__label" for="remember">Remember me</label>
                                </div>
                                <!-- forgetPassword -->
                                <div class="forgotPassword">
                                    <a href="" class="forgotPass">
                                        Forgot passwords?
                                    </a>
                                </div>
                            </div>
                            <div class="btn_wrapper single_input">
                                <button type="submit" class="cmn_btn w-100 radius-5">
                                    Sign In
                                </button>
                            </div>
                            <div class="btn-wrapper mt-4">
                                <p class="loginForm__wrapper__signup">
                                    <span>
                                        Don’t have an account ?
                                    </span>
                                    <a href="{{ route('register') }}" class="loginForm__wrapper__signup__btn">
                                        Sign Up
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
                                        <img src="{{ asset('assets/img/icon/fbIcon.svg') }}" alt=""
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
        $(document).ready(function() {
            $('.custom_form').on('submit', function(e) {
                e.preventDefault();

                let username_email = $('#username_email').val();
                let password = $('#password').val();

                $.ajax({
                    url: "{{ route('login.user') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        username_email: username_email,
                        password: password,
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
                            if (errors.username_email) {
                                $('#showErrorEmail').text(errors.username_email[0]);
                            }
                            if (errors.password) {
                                $('#showErrorPassword').text(errors.password[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
