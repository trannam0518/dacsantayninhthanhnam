<!DOCTYPE html>
<html lang="vn">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Metro 4 -->
    <link rel="stylesheet" href="{{asset('public/frontend/vendors/metro4/css/metro-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontend/css/index.css')}}">
    <title>@yield('title')</title>

    
</head>
<body>
    <aside class="sidebar pos-absolute z-2"
       data-role="sidebar"
       data-toggle="#sidebar-toggle-3"
       id="sb3"
       data-shift=".shifted-content">
    <div class="sidebar-header" data-image="{{asset('public/frontend/images/home.jpg')}}">
        <!-- <div class="avatar">
            <img data-role="gravatar" data-email="a@b.com" data-default="identicon">
        </div> -->
    </div>
    <ul class="sidebar-menu">
        <li><a href="{{url('/')}}"><span class="mif-cart icon"></span>Soạn Đơn Hàng</a></li>
        <li><a href="{{url('/allorder')}}"><span class="mif-table icon"></span>Danh sách Đơn Hàng</a></li>
        <li><a href="{{url('/customers')}}"><span class="mif-users icon"></span>Khách Hàng</a></li>
        <li><a href="{{url('/products')}}"><span class="mif-stack3 icon"></span>Sản Phẩm</a></li>
        <li><a href="{{url('/mapcustomer')}}"><span class="mif-map icon"></span>Vị trí khách hàng</a></li>

        <li class="divider"></li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="mif-exit icon"></span>LogOut</a></li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
    </aside>
    <div class="shifted-content h-100 p-ab">
        <div class="app-bar pos-absolute bg-red z-1" data-role="appbar">
            <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
                <span class="mif-menu fg-white"></span>
            </button>
        </div>
        
        @yield('content')
        

        

    </div>
    <!-- <div id="bottom-navi" class="bottom-nav pos-absolute">
        <a class="button warning drop-shadow" >
            <span class="icon mif-users"></span>
            <span class="label">Khách Hàng</span>
        </a>
        <a class="button primary drop-shadow" >
            <span class="icon mif-cart"></span>
            <span class="label">Soạn Đơn Hàng</span>
            <span class="badge bg-red fg-white">4</span>
        </a>
        <a class="button primary drop-shadow" >
            <span class="icon mif-cart">Các Đơn Hàng</span>
            <span class="label"></span>
        </a>
        <a class="button success drop-shadow" >
            <span class="icon mif-table"></span>
            <span class="label">Sản Phẩm</span>
        </a>
    </div> -->
<!-- jQuery first, then Metro UI JS -->
<!-- <script src="{{asset('public/frontend/vendors/chartjs/Chart.bundle.min.js')}}"></script>
<script src="{{asset('public/frontend/vendors/qrcode/qrcode.min.js')}}"></script>
<script src="{{asset('public/frontend/vendors/jsbarcode/JsBarcode.all.min.js')}}"></script>
<script src="{{asset('public/frontend/vendors/ckeditor/ckeditor.js')}}"></script> -->
<script src="{{asset('public/frontend/vendors/metro4/js/metro.min.js')}}"></script>
<script src="{{asset('public/frontend/js/index.js')}}"></script>
    


    <!-- <script>
        $(document).ready(function() {
        $(window).scroll(function(event) {
            $('#bottom-navi').hide();
            setTimeout(function(){ $('#bottom-navi').show();}, 1000);
        });
    });
    </script> -->
</body>
</html>
