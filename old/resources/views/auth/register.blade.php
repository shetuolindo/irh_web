<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up - Islamic Resource Hub</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{ asset('irh_assets/vendor/bootstrap/bootstrap.min.css') }}" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <style>
        a,a:hover
        {
        text-decoration: none;
        color:#333;
        }
        body
        {
        background: linear-gradient(rgba(255, 205, 36, 0.5),rgba(51, 57, 61, 0.5)), url({{ asset('irh_assets/images/loginbg.jpg') }});
        background-position: center;
        background-size: cover;
        background-position-y: bottom;
        background-repeat: no-repeat;
        height: 100vh;
        overflow-x: hidden;
        }
        .container
        {
        position: absolute;
        left: 0;
        right: 0;
        top: 10%;
        }
        .sign-in-wrapper
        {
        background:#fff;
        padding:20px;
        height: 620px;
        }
        .sign-up-wrapper
        {
        background: #2AABE4;
        opacity: 0.9;
        padding:20px;
        height: 550px;
        color:#fff;
        }
        #sign-up-container
        {
        position: absolute;
        width: 100%;
        right: 0;
        top: 6%;
        }
        .form-control {
        border: 1px solid #495057;
        border-radius: 1.25rem;
        }
        .btn.btn-login
        {
        border-radius: 1.25rem;
        background: #26a0d6;
        border: 1px solid #249cd2;
        }
        .btn.btn-yellow
        {
        border-radius: 1.25rem;
        background: #FFCD24;
        border: 1px solid #FFCD24;
        color:#333;
        }
        @media screen and (max-width: 546px)
        {
        #sign-up-container
        {
        position: relative;
        }
        .sign-in-wrapper, .sign-up-wrapper
        {
        padding: 60px;
        }
        }
        @media screen and (max-width: 1024px)
        {
        .sign-in-wrapper, .sign-up-wrapper
        {
        padding: 80px;
        }
        }
        @media screen and (max-width: 768px)
        {
        .sign-in-wrapper
        {
        padding: 50px;
        /*height: 374px;*/
        }
        .sign-up-wrapper
        {
        padding: 50px;
        /*height: 315px;*/
        }
        }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-0" id="login-container">
                    <div class="sign-in-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <h4>Sign Up</h4>
                                    <br>
                                    <form action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="First Name .." required autofocus>
                                            @if ($errors->has('first_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name .." required autofocus>
                                            @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email .." required>
                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username .." required>
                                            @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password .." required>
                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password .." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" value="accept" name="terms" required> <small class="ml-1">Agree to our <a href="">Terms &amp; Conditions</a></small>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="user_role" value="user">
                                            <input type="submit" class="btn btn-primary btn-block btn-login" value="Sign Up">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-0" id="sign-up-container">
                    <div class="sign-up-wrapper">
                       <div class="container">
                           <div class="row">
                               <div class="col-md-6 offset-md-3">
                                    <h4>Sign In</h4>
                                    <p>Sign In to Islamic Resource Hub</p>
                                    <a href="{{ route('login') }}" class="btn btn-block btn-yellow">Sign In</a>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>