<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="{{config("app.site_name")}}">
        <meta name="author" content="{{config("app.site_name")}}">

        
    <link rel="shortcut icon" href="{{asset("admin")}}/images/favicon.ico">

        <title>Admin Login</title>

        <!-- Base Css Files -->
        <link href="{{ asset("admin")}}/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Font Icons -->

        <!-- animate css -->
        <link href="{{ asset("admin")}}/css/animate.css" rel="stylesheet" />

        <!-- Waves-effect -->
        <link href="{{ asset("admin")}}/css/waves-effect.css" rel="stylesheet">

        <!-- Custom Files -->
        <link href="{{ asset("admin")}}/css/helper.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset("admin")}}/css/style.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset("admin")}}/css/custom.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
            <style>
                input
                {
                    border: 1px solid #ddd!important;
                }
            </style>
        <script src="{{ asset("admin")}}/js/modernizr.min.js"></script>
        
    </head>
    <body>


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-heading bg-img"> 
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white"> Sign In to <strong>{{ config('app.name') }}</strong> </h3>
                </div> 
                <div class="panel-body">
                    <form method="POST" action="{{ route('login') }}">
                            @csrf
                    <div class="form-group ">
                        <div class="col-xs-12">
                                <input id="email" type="email" class="input-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg @error('password') is-invalid @enderror" type="password" name="password" required="" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-lg w-lg waves-effect waves-light">
                                    {{ __('Login') }}
                                </button><br>
                        </div>
                    </div>

                </form> 
                </div>                                 
                
            </div>
        </div>
	</body>
</html>