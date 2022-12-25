<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                <h2 class="header-greetings">Hi, <a href="{{ route('page.user.index'); }}" id="header-userName">{{ strtok(Auth::user()->name, ' '); }}</a></h2>
                <a class="header-links" href="{{ route('page.edit-user'); }}">Settings</a> <span class="header-divisor">|</span> 
                <a class="header-links" href="{{ route('do-logout'); }}">Logout</a>
                @endauth

                @guest
                <h2 class="header-greetings">Hello!</h2>
                <a class="header-links" href="{{ route('page.login'); }}">Login</a> <span class="header-divisor">|</span> 
                <a class="header-links" href="{{ route('page.register'); }}">Register</a>
                @endguest
            </div>
        </div>
    </header>
    
    <div id="body-content">
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
