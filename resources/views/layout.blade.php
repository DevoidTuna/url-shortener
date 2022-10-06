<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dev.ly - URL Shortener</title>
    <link rel="stylesheet" href="{{ URL::asset('/css/layout.css'); }}" >
</head>
<body>
    <header>
        
        <div id="img-logo">
            <img src=" {{ URL::asset('/midia/logo.png'); }} " alt="logotipo Dev.ly">
        </div>

        <div id="header-user">
            @auth
                Hello, User!
            @endauth
            @guest
                <p>Hello</p>
                <a href=" {{ route('page.login') }} ">Login</a> | 
                <a href=" {{ route('page.register') }} ">Register</a>
            @endguest
        </div>

    </header>

    <div id="conteudo">
        @yield('content')
    </div>

    <footer>
        <p>DevTuna Company© 2022</p>
        <i>All rights reserved.</i>
    </footer>
</body>
</html>