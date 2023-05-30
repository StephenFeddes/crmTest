<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/navigbar.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
        <link rel="shortcut icon" type="image/png" href="./images/urbancom.png"/>
        @yield('styling')
        @yield('title')
    </head>
    <body>
        @include('partials.navbar')
        @yield('content')
    </body>
</html>