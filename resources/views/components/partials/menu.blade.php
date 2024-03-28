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
        <a class="simple-text logo-normal">
            西原商会 社販サイト管理
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li>
                <x-nav-link to="/" class="{{ $highlightCheck['customer'] }}">
                    <i class="fa fa-address-book-o"></i>
                    <p>顧客管理</p>
                </x-nav-link>
            </li>
        </ul>
    </div>
</div>
