<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dev.ly - URL Shortener</title>
    @vite('resources/css/layout.css')
</head>
<body>
    <header>
        <div class="header-buttons">
            <div id="img-logo">
                <a href="{{ route('page.index'); }}"><img src=" {{ Vite::asset('public/midia/logo-white.png'); }} " alt="logotipo Dev.ly"></a>
            </div>

            <div id="header-user">
                @auth
                    <h2 class="header-greetings">Hi, {{ strtok(ucfirst(Auth::user()->name), ' '); }}!</h2>
                    <a href="{{ route('page.user.index'); }}">Profile</a> | 
                    <a href="{{ route('do-logout'); }}">Logout</a>
                @endauth

                @guest
                    <h2 class="header-greetings">Hello!</h2>
                    <a href="{{ route('page.login'); }}">Login</a> | 
                    <a href="{{ route('page.register'); }}">Register</a>
                @endguest
            </div>
        </div>
    </header>

    <div id="body-content">
        <div id="sidebar" style="display: none">
            <h3 id="titlePage">{{ $namePage; }}</h3>
            <div class="sidebar-links">
                @auth
                    <ul>
                        <li>
                            <a href="{{ route('page.user.index'); }}">My URL's</a>
                        </li>
                    </ul>
                @endauth
                    
                @guest
                    <ul>
                        <li>
                            <a href="{{ route('page.login'); }}">Login</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="{{ route('page.register'); }}">Register</a>
                        </li>
                    </ul>
                @endguest
            </div>
        </div>

        <div id="content-container">
            @yield('content')
        </div>
    </div>

    <footer>
        <p>DevTuna Company© {{ date("Y"); }}</p>
        <i>All rights reserved.</i>
    </footer>
</body>
</html>
