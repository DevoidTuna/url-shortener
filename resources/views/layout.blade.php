<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dev.ly - URL Shortener</title>
    <link rel="stylesheet" href="{{ URL::asset('css/layout.css'); }}" >
</head>
<body>
    <header>
        <div class="header-buttons">
            <div id="img-logo">
                <img src=" {{ URL::asset('/midia/logo-orange.png'); }} " alt="logotipo Dev.ly">
            </div>

            <div id="header-user">
                @auth
                    <p class="header-greetings">Hello,</p>
                    <a href="{{ route('page.user.index') }}">User!</a>
                @endauth

                @guest
                    <p class="header-greetings">Hello!</p>
                    <a href="{{ route('page.login') }}">Login</a> | 
                    <a href="{{ route('page.register') }}">Register</a>
                @endguest
            </div>
        </div>
    </header>

    <div id="body-content">
        <div id="sidebar">
            <h3 id="titlePage">{{ $namePage }}</h3>
            <div class="sidebar-links">
                @auth
                    <ul>
                        <li>
                            <a href="{{ route('page.user.index') }}">Profile</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="{{ route('page.user.index') }}">My URL's</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="{{ route('page.create-url') }}">Create new URL</a>
                        </li>
                    </ul>
                @endauth
                    
                @guest
                    <ul>
                        <li>
                            <a href="{{ route('page.login') }}">Login</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="{{ route('page.register') }}">Register</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="{{ route('page.create-url') }}">Create new URL</a>
                        </li>
                    </ul>
                @endguest
            </div>
        </div>

        <div id="content">
            @yield('content')
        </div>
    </div>

    <footer>
        <p>DevTuna Company© {{date("Y")}}</p>
        <i>All rights reserved.</i>
    </footer>
</body>
</html>