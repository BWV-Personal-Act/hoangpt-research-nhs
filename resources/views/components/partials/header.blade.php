@props(['headerTitle'])
<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand">{{ $headerTitle }}</a>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <label style="padding-right:20px;">
                            {{ auth()->user()->name }}
                        </label>
                    </li>
                    <li class="nav-item">
                        <label style="padding-right:20px">
                            <x-nav-link :to="route('auth.handleLogout')">
                                <i class="fa fa-sign-out"></i>
                            </x-nav-link>
                        </label>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
