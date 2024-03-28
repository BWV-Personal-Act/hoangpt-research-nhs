<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-language" content="ja">
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="robots" content="noindex,nofollow,noarchive" />
    <title>
        {{ $title }} | shahaaan!! 管理
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- common CSS -->
    <link href="{{ mix('css/common.css') }}" rel="stylesheet" />
    <link href="{{ mix('css/custom.css') }}" rel="stylesheet" />
    <x-env-styles />
    @stack('style')
</head>

<body class="bgc-body">

    {{ $slot }}

    @stack('scripts')
</body>

</html>
