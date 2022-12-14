@section('content')
<!DOCTYPE html>
<head>
    @vite(['resources/css/register.css', 'resources/js/register.js'])
    <title>Register - Dev.ly</title>
</head>
<div class="container-register">
    <h2>Register.</h2>
    <form action="{{ route('do-register') }}" method="POST" id="form-register">
        @csrf
        <div id="boxes-container">
            <div class="box">
                <label for="register-name">Name:</label>
                <input type="text" name="name" id="register-name" placeholder="Jake Nathan" required>
                <span class="spanError" id="span-name">Your name need to have 3 or more letters</span>
            </div>
            <div class="box">
                <label for="register-email">E-mail: </label>
                <input type="email" name="email" id="register-email" placeholder="Your email address" required>
                <span class="spanError" id="span-email">This email address isn't valid</span>
            </div>
            <div class="box">
                <label for="register-password">Password:</label>
                <input type="password" name="password" id="register-password" placeholder=" Create password (min 6 letters)" required>
                <span class="spanError" id="span-password">The password must be 6 or more characters</span>
            </div>
            <div class="box">
                <label for="confirm-password">Confirm<br>Password:</label>
                <input type="password" name="password_confirmation" id="confirm-password" placeholder="Enter your password again" required>
                <span class="spanError" id="span-confirmPassword">The passwords entered do not match</span>
            </div>
            <div class="bottom-buttons">
                <a href="{{ route('page.login') }}">Have an account?</a><br>
                <button type="button" name="btn-register" id="btn-register">REGISTER</button>
            </div>
        </div>
    </form>
</div>
@endsection
@include('layout')
