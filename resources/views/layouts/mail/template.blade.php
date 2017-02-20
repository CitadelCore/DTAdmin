<!DOCTYPE html>
<html lang="en">
    <head>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>{{ $title }}</title>
    </head>
    <body>
    <div style="font-family: 'Roboto', sans-serif;">
    <h3>{{ $titledetail }}</h3>
    @yield('message')
    <br>
    Message Ident: {{ $ident }}
    </div>
    </body>
</html>
