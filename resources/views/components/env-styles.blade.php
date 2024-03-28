@php
    $envColor = config('nhs_ihs.env_color');
@endphp
@if (!empty($envColor))
    <style>
        .login_form_btm {
            background-color: {{ $envColor }};
        }

        .bgc-body {
            background-color: {{ $envColor }};
        }
    </style>
@endif
