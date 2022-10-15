<head>
    <link rel="stylesheet" href="{{ URL::asset('css/register.css'); }}">
</head>
@section('content')
@auth
{{route('page.user')}}
@endauth

@guest
<div class="container-register">
    <h2>Register.</h2>
    <form action="{{ route('do-register') }}" method="POST">
        @csrf
        <div id="boxes-container">
            <div class="box">
                <label for="register-name">Name:</label>
                <input type="text" name="name" id="register-name" oninput="check()" required>
            </div>
            <div class="box">
                <label for="register-email">E-mail: </label>
                <input type="email" name="email" id="register-email" oninput="check()" required>
            </div>
            <div class="box">
                <label for="register-password">Password:</label>
                <input type="password" name="password" id="register-password" oninput="check()" required>
            </div>
            <div class="box">
                <label for="confirm-password">Confirm<br>Password:</label>
                <input type="password" name="confirm-password" id="confirm-password" oninput="check()" required>
            </div>
            <div class="bottom-buttons">
                <a href="{{ route('page.login') }}">Have an account?</a><br>
                <button type="submit" name="btn-register" id="btn-register">REGISTER</button>
            </div>
        </div>
    </form>
</div>
@endguest

@endsection
<script src="{{ URL::asset('js/register.js'); }}"></script>
@include('layout')