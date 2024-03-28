<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="robots" content="noindex,nofollow,noarchive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ $title }} | shahaaan!! 管理
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/paper-dashboard.css?v=2.0.2') }}" rel="stylesheet" />
    <!-- table css -->
    <link href="{{ asset('css/table.css') }}" rel="stylesheet" />
    <!-- toggle -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- chosen select -->
    <link rel="stylesheet" href="{{ asset('js/library/chosen/chosen.css') }}">
    <!-- common CSS -->
    <link href="{{ mix('css/common.css') }}" rel="stylesheet" />
    <link href="{{ mix('css/custom.css') }}" rel="stylesheet" />
    <x-env-styles />
    @stack('style')
</head>

<body>
    {{ $slot }}
    <div id="loading" style="display: none">
        <div class="lds-dual-ring"></div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
    <!-- jquery validation -->
    <script src="{{ asset('js/library/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/library/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- common JS -->
    <script src="{{ mix('js/common.js') }}"></script>
    <script src="{{ mix('js/library/jquery-validation/additional-setting.js') }}"></script>
    @stack('scripts')
</body>

</html>
