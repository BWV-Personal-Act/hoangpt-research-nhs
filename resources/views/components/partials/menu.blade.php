<?php
$highlightClass = 'side-selection';
$currentRouteName = request()->route()->getName();
$menuHighlightConfig = getList('menu.menu_highlight');
$highlightCheck = [];
foreach ($menuHighlightConfig as $highlightName => $routes) {
    $highlightCheck[$highlightName] = null;
    if (in_array($currentRouteName, $routes)) {
        $highlightCheck[$highlightName] = $highlightClass;
    }
}
?>
<div class="sidebar" data-color="white">
    <div class="logo">
        <a class="side-title logo-normal">
            <img src="{{ asset('img/logo.png') }}" alt="" class="side-img">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li>
                <x-nav-link to="{{ route('user.search') }}" class="{{ $highlightCheck['user'] }}">
                    <i class="fa fa-users"></i>
                    <p>User List</p>
                </x-nav-link>
            </li>
            <li>
                @if (auth()->user()->position_id == 0)
                <x-nav-link to="{{ route('group.list') }}" class="{{ $highlightCheck['group'] }}">
                    <i class="fa fa-address-book-o"></i>
                    <p>Group List</p>
                </x-nav-link>
                @endif
            </li>
        </ul>
    </div>
</div>
