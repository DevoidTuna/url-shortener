<!DOCTYPE html>
<head>
    @vite('resources/css/login.css')
    <title>Login - Dev.ly</title>
</head>
@section('content')
<div class="container-login">
    <h2>Login.</h2>
    <form action="{{ route('do-login') }}" method="POST">
        @csrf
        <label for="user-email">E-mail</label><br>
        <input type="email" name="email" id="user-email" required placeholder="Your email"><br>
        <label for="user-password">Password</label><br>
        <input type="password" name="password" id="user-password" placeholder="Your password" required><br>
        @if($notRegistered)
        <span class="errorMessage">Invalid email or password.</span>
        @endif
        <div class="bottom-buttons">
            <div class="button-remember-me">
                <a href="{{route('page.password-reset')}}">Forgot your password?</a>
            </div>
            <a href="{{ route('page.register') }}">Register now.</a>
        </div>
        <button type="submit" name="btn-login" id="btn-login">LOGIN</button>
    </form>
</div>
@endsection
@include('layout')
