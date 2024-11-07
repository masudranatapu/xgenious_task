<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Set Forget Password - Xgenious Task</title>
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
                            Set Forgot Password
                        </h2>
                        <p class="loginForm__header__para mt-3">Login with your data that you entered during
                            registration.</p>
                    </div>
                    <div class="loginForm__wrapper mt-4">
                        <form class="custom_form">
                            <input type="hidden" value="{{ $user->remember_token }}" id="token">
                            <div class="single_input">
                                <label class="label_title">Enter Password</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="Password" id="password"
                                        placeholder="New Password" required>
                                    <div class="icon">
                                        <span class="material-symbols-outlined">mail</span>
                                    </div>
                                </div>
                                <span id="showErrorEmailUsername" class="text-danger"></span>
                            </div>
                            <div class="single_input">
                                <label class="label_title">Confirm Password</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="Password" id="password_confirmation"
                                        placeholder="Confirm Password" required>
                                    <div class="icon">
                                        <span class="material-symbols-outlined">mail</span>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_wrapper single_input d-flex gap-2">
                                <button type="submit" class="cmn_btn w-100 radius-5">Set Password</button>
                                <a href="{{ route('login.user') }}" class="cmn_btn outline_btn w-100 radius-5">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="loginForm__right loginForm__bg " style="background-image: url(assets/img/login.jpg);">
                <div class="loginForm__right__logo">
                    <div class="loginForm__logo">
                        <a href=""><img src="{{ asset('assets/img/logo.webp') }}" alt=""></a>
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

                let token = $('#token').val();
                let password = $('#password').val();
                let password_confirmation = $('#password_confirmation').val();

                $.ajax({
                    url: "{{ route('set.forget.Password') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        forget_token: token,
                        password: password,
                        password_confirmation: password_confirmation,
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
                            if (errors.password) {
                                $('#showErrorEmailUsername').text(errors.password[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
