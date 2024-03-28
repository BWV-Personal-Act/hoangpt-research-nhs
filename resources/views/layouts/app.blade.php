<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="content-language" content="ja">
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
    <link href="{{ asset('css/fontawesome/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.css"/>
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

<body class="bgc-body">
    <div class="wrapper">

        <!-- サイドメニュー -->
        <x-partials.menu />
        <!-- サイドメニュー -->

        <div class="main-panel">
            <!-- ヘッダー -->
            <x-partials.header :headerTitle="$headerTitle ?? $title" :classIconLabel="$headerIconLabel ?? ''" />
            <!-- ヘッダー -->

            <!-- メイン -->
            <div class="content">
                @if (Session::has('error'))
                    @php
                        $errorType = 'danger';
                        $errorMessages = Session::get('error');
                    @endphp
                    <x-alert :messages="$errorMessages" :type="$errorType" />
                @endif
                @if (Session::has('success'))
                    @php
                        $successType = 'success';
                        $successMessages = Session::get('success');
                    @endphp
                    <x-alert :messages="$successMessages" :type="$successType" />
                @endif
                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger">
                        <ul class="m-0">
                            @php
                                $errorsUnique = array_unique($errors->all());
                            @endphp
                            @if (count($errorsUnique) === 1)
                                @foreach ($errorsUnique as $error)
                                    {!! $error !!}
                                @endforeach
                            @else
                                @foreach ($errorsUnique as $error)
                                    <li>{!! $error !!}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
                {{ $slot }}
            </div>
            <!-- メイン -->

            <!-- フッター -->
            <x-partials.footer />
            <!-- フッター -->
        </div>
    </div>
    <div id="loading" style="display: none">
        <div class="lds-dual-ring"></div>
    </div>

    @stack('modals')

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
    <!-- toggle -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- chosen select -->
    <script src="{{ asset('js/library/chosen/chosen.jquery.js') }}"></script>
    <!-- jquery validation -->
    <script src="{{ asset('js/library/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/library/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- common JS -->
    <script src="{{ mix('js/common.js') }}"></script>
    <script src="{{ mix('js/library/jquery-validation/additional-setting.js') }}"></script>
    <!-- Datepicker -->
    <script src="{{ asset('js/datepicker.js') }}"></script>
    <script src="{{ asset('js/datepicker.ja-JP.js') }}"></script>
    <!-- moment -->
    <script src="{{ asset('js/moment.js') }}"></script>
    <!-- datatables -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.js"></script>
    
    @stack('scripts')
</body>

</html>
