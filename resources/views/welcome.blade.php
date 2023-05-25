<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ url('login')}}", method='POST'>
        @csrf
        <label for="username">Username</label>
        <input type="text" id="username" name="username"></label>
        <label for="password">Password</label>
        <input type="password" id="password" name="password"></label>
        <button type="submit">Log in</button>
    </form>
</body>
</html>