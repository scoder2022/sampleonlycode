<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login  </title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <style>
        body,html {
            background-image: url('https://i.imgur.com/xhiRfL6.jpg');
            height: 100%;
        }

        #profile-img {
            height:180px;
        }
        .h-80 {
            height: 80% !important;
        }
    </style>
</head>
<body>

<div class="container h-80">
    <div class="row align-items-center h-100">
        <img id="profile-img" class="profile-img-card" src="{{  asset('admins/images/secretlogo.png') }}" style="width: 569px"/>
        <div class="col-4 mx-auto">
            <div class="text-center">
                <h3 style="color: cyan">Admin Login</h3>
                @error('email')
                <div class="help-block error center" style="color:red;text-align: center">
                    <p><strong>{{ $message }}</strong></p>
                    <p><strong>Please Check Your E-Mail And Password </strong></p>
                </div>
                @enderror
                <p id="profile-name" class="profile-name-card"></p>
                <form  class="form-signin" action="{{route('login')}}" method="post" id="form">
                    @csrf
                    <input type="email" name="email" class="form-control form-group" placeholder="email" required autofocus>
                    <input type="password" name="password" id="inputPassword" class="form-control form-group" placeholder="password" required autofocus>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Login</button>
                </form><!-- /form -->
                <div style="margin:auto">
                    <a href="" style="margin-left: 220px">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.js"
    integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI="
    crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>
<script type="text/javascript">
    var onloadCallback = function() {
    };
    $('#form').submit(function(f){
        var verified = grecaptcha.getResponse();
        if(verified.length === 0){
            $('.test').html('<div class="help-block error center" style="color:red;text-align: center">\n' +
                '                    <p><strong>Please fill the recaptcha</strong></p>\n' + '\n' + '                </div>');
            f.preventDefault();
        }
    });

</script>
</html>
