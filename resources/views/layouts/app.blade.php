
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

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

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
                @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>