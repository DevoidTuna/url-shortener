<!DOCTYPE html>
@section('content')
<head>
    @vite(['resources/css/passwordReset.css', 'resources/js/passwordReset.js'])
	<title>Password Recovery - Dev.ly</title>
</head>
<div class="bodyContainer">
	<h2>Reset your password.</h2>
	<form action="{{ route('do-password-new', ['user' => $user]) }}" method="POST" id="form-updatePassword">
		@csrf
		<label for="new-password">New password</label><br>
        <input type="password" name="password" id="new-password" placeholder="Min 6 letters" required><br>
		<span id="span-password">The password must be 6 or more characters</span>
		<label for="confirm-password">Confirm the new password</label><br>
        <input type="password" name="confirm-password" id="confirm-password" placeholder="Insert your new password again" required><br>
		<span id="span-confirmPassword">The passwords entered do not match</span>

		<button id="btn-updatePassword">UPDATE PASSWORD</button>
	</form>
</div>
@endsection
@include('layout')
