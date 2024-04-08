<x-login-layout title="ログイン">
    <div class="wrapper d-flex align-items-center">
        <form method="POST" action="{{ route("auth.handleLogin") }}" id="login-form" class="login-form content row" style="width:100%; margin:0;" autocomplete="off">
            <div class="mx-auto px-0 text-center" style="max-width: 1000px;">
                @if (isset($errors) && $errors->any())
                    <x-alert :messages="$errors->all()" type="danger"  />
                @endif
            </div>

            @csrf

            <div class="login_form_btm">
                <div class="form-floating mb-3 wk">
                    <input type="text" class="form-control col-md-5" id="floatingInput" name="email" value="{{ old('email') }}" data-label="Email">
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating wk">
                    <input type="password" class="form-control col-md-5" id="floatingPassword" name="password" data-label="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <button type="submit" class="btn btn--shadow col-md-5">Login</button>
            </div>
        </form>
    </div>
    @push('style')
        <link href="{{ mix('css/screens/auth/login.css') }}" rel="stylesheet" />
    @endpush
    @push('scripts')
        <script src="{{ mix('js/screens/auth/login.js') }}"></script>
    @endpush
</x-login-layout>
