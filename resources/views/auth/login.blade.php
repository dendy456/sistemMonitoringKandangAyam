
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Monitoring Kandang Ayam </title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link rel="apple-touch-icon" href="{{ asset('style/images/unmul.png') }}">
    <link rel="shortcut icon" href="{{ asset('style/images/unmul.png') }}">

    <link rel="stylesheet" href="{{ asset ('style/assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset ('style/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('style/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('style/assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset ('style/assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset ('style/assets/css/cs-skin-elastic.css') }}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="{{ asset ('style/assets/scss/style.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body class="bg-dark">


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="">
                        <img class="align-content" src="{{ asset('style/images/ayamLogo.png') }}" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form action="{{ 'do-login' }}" method="POST">
                    {!! csrf_field() !!}
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" id="username" type="text"  name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        </br>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox">
                                {{ __('Remember Me') }}
                            </label>
                            <!-- <label class="pull-right">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </label> -->

                        </div></br></br></br>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                        </br></br>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset ('style/assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset ('style/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset ('style/assets/js/plugins.js') }}"></script>
    <script src="{{ asset ('style/assets/js/main.js') }}"></script>


</body>
</html>
