<!DOCTYPE html>
<head>
    @vite('resources/css/login.css')
</head>
@section('content')
@auth
    <h3>You are already logged in.</h3>
@endauth
@guest
<div class="container-login">
    <h2>Login.</h2>
    <form action="{{ route('do-login') }}" method="POST">
        @csrf
        <label for="user-email">E-mail</label><br>
        <input type="email" name="email" id="user-email" required><br>
        <label for="user-password">Password</label><br>
        <input type="password" name="password" id="user-password" required><br>
        @if(isset($notRegistered))
            <span class="errorMessage">Invalid email or password.</span>
        @endif
        <div class="bottom-buttons">
            <div class="button-remember-me">
                <input type="checkbox" name="rememberMe" id="checkbox-remember-me">
                <label for="checkbox-remember-me" id="label-remember-me">Remember me.</label>
            </div>
            <a href="{{ route('page.register') }}">Register now.</a>
        </div>
        <button type="submit" name="btn-login" id="btn-login">LOGIN</button>
    </form>
</div>
@endguest
@endsection

@include('layout')
