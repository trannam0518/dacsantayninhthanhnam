<!DOCTYPE html>
<html lang="vn">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Metro 4 -->
    <link rel="stylesheet" href="{{asset('public/frontend/vendors/metro4/css/metro-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontend/css/index.css')}}">

    <title>Đăng Nhập</title>
</head>
<body >


    <div class="m4-cloak h-vh-100 d-flex flex-justify-center flex-align-center">

        <div class="login-box">
            <form class="bg-white p-4"
                  action="{{ route('login') }}" 
                  data-role="validator"
                  data-clear-invalid="2000"
                  data-on-error-form="invalidForm"
                  method="POST"
                  
            >
                @csrf
                <img src="{{asset('public/frontend/images/home.jpg')}}" class="place-right">
                <h1 class="mb-0 text-center">Đăng Nhập</h1>
                <div class="text-muted mb-4 text-center">Đăng nhập để bắt đầu làm việc</div>
                @error('email')
                                    <div class="invalid-feedback text-center ">
                                        <strong>{{ $message }}</strong>
                                    </div>
                @enderror
                @error('password')
                                    <div class="invalid-feedback text-center">
                                        <strong>{{ $message }}</strong>
                                    </div>
                @enderror
                <div class="form-group">
                    <input class="@error('email') is-invalid @enderror" type="text" id="email" name="email" value="{{ old('email') }}" data-role="input" placeholder="Email" data-append="<span class='mif-envelop'>" data-validate="required" autofocus>
                    <span class="invalid_feedback">vui lòng nhập email</span>
                </div>
                <div class="form-group">
                    <input class="@error('password') is-invalid @enderror" type="password" id="password" name="password" data-role="input" placeholder="mật khẩu" data-append="<span class='mif-key'>" data-validate="required">
                    <span class="invalid_feedback">vui lòng nhập mật khẩu</span>
                </div>
                <div class="form-group d-flex flex-align-center flex-justify-between">
                    <input id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox" data-role="checkbox" data-caption="Ghi nhớ">
                    @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Đăng kí') }}</a>
                                </li>
                    @endif
                    <button class="button primary">Đăng nhập</button>
                </div>                   
            </form>
        </div>
    
    </div>
    


    <script src="{{asset('public/frontend/vendors/jquery/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('public/frontend/vendors/metro4/js/metro.min.js')}}"></script>

    <script>
        function invalidForm(){
            var form  = $(this);
            form.addClass("ani-ring");
            setTimeout(function(){
                form.removeClass("ani-ring");
            }, 1000);
        }
    </script>
    
</body>
</html>