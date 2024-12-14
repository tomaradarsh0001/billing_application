<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login to Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/themefy_icon/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/font_awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/scroll/scrollable.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style1.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/colors/default.css') }}" id="colorSkinCSS">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 m-0">
<div class="container-fluid p-0">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="modal-content cs_modal">
                                    <div class="modal-header justify-content-center theme_bg_1">
                                        <h5 class="modal-title text_white">LOGIN</h5>
                                    </div>
                                    <div class="modal-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="inputEmail">Email address</label>
            <input id="inputEmail" type="email" name="email" placeholder="Enter your email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">

            @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="inputPassword">Password</label>
            <input id="inputPassword" type="password" name="password" placeholder="Password" class="form-control" required autocomplete="current-password">

            @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn_1 full_width text-center">Log in</button>
        </div>

        <p class="text-center">Need an account? <a href="#" data-bs-toggle="modal" data-bs-target="#sing_up" data-bs-dismiss="modal">Sign Up</a></p>
        
        @if (Route::has('password.request'))
            <div class="text-center">
                <a class="pass_forget_btn" href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        @endif
    </form>
</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<script src="{{ asset('assets/js/jquery1-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/metisMenu.js') }}"></script>
<script src="{{ asset('assets/vendors/scroll/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/vendors/scroll/scrollable-custom.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>
