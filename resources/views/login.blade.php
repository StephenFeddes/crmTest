<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/loginPage.css">
        <link rel="shortcut icon" type="image/png" href="./images/urbancom.png"/>
        <title>Login</title>
    </head>
    <body>
        <div class="login-form">
            <div class="urbancom-logo"><img src="./images/urbancom.png" alt="Urbancom logo"></div>
            <form autocomplete="off" action="{{ url('login')}}", method='POST'>
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </body>
</html>