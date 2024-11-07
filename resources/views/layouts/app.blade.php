<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xgenious Task</title>
    <link rel=icon href="favicons.png" sizes="16x16" type="icon/png">
    @include('layouts.style')
    <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">
    <!-- dark css -->
</head>

<body>
    <div class="dashboard__area">
        <div class="container-fluid p-0">
            <div class="dashboard__contents__wrapper">
                <div class="dashboard__left dashboard-left-content">
                    @include('layouts.sidebar')
                </div>
                <div class="dashboard__right">
                    <div class="dashboard__header single_border_bottom">
                        @include('layouts.header')
                    </div>
                    <div class="dashboard__body posPadding">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.script')
    <script src="{{ asset('toastr/toastr.js') }}"></script>
    {!! Toastr::message() !!}
</body>

</html>
