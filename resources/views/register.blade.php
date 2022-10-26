@section('content')
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/register.css'); }}">
</head>
@auth
{{route('page.user')}}
@endauth

@guest
<div class="container-register">
    <h2>Register.</h2>
    <form action="{{ route('do-register') }}" method="POST" id="form-register">
        @csrf
        <div id="boxes-container">
            <div class="box">
                <label for="register-name">Name:</label>
                <input type="text" name="name" id="register-name" placeholder="Jake Nathan" required>
                <span id="span-name">Your name need to have 3 or more letters</span>
            </div>
            <div class="box">
                <label for="register-email">E-mail: </label>
                <input type="email" name="email" id="register-email" placeholder="Your email address" required>
                <span id="span-email">This email address isn't valid</span>
            </div>
            <div class="box">
                <label for="register-password">Password:</label>
                <input type="password" name="password" id="register-password" placeholder=" Create password (min 6 letters)" required>
                <span id="span-password">The password must be 6 or more characters</span>
            </div>
            <div class="box">
                <label for="confirm-password">Confirm<br>Password:</label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Enter your password again" required>
                <span id="span-confirmPassword">The passwords entered do not match</span>
            </div>
            <div class="bottom-buttons">
                <a href="{{ route('page.login') }}">Have an account?</a><br>
                <button type="button" name="btn-register" id="btn-register">REGISTER</button>
            </div>
        </div>
    </form>
</div>
@endguest
<script src="{{ URL::asset('js/register.js'); }}"></script>
@endsection
@include('layout')
