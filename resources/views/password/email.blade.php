<!DOCTYPE html>
@section('content')
<head>
    @vite('resources/css/passwordEmail.css')
	<title>Password Recovery - Dev.ly</title>
</head>
<div class="bodyContainer">
	<h2>Reset your password.</h2>
	<form action="{{ route('do-password-reset') }}" method="POST">
		@csrf
		@if ($status != 0)
			@if ($status == 'success')
				<div class="successMessage statusMessage">
					Send email with sucess. Check your email inbox.
				</div>
			@elseif ($status == 'notFound')
				<div class="errorMessage statusMessage">
					Email not found.
				</div>
			@elseif ($status == 'notToken')
				<div class="errorMessage statusMessage">
					Token not found or expired. Try to send a new password recovery.
				</div>
			@else
				<div class="errorMessage statusMessage">
					Not work. Try again later.
				</div>
			@endif
		@endif
		<label for="user-email">E-mail</label><br>
        <input type="email" name="email" id="user-email" placeholder="Your email" required>
		<button type="submit">SEND EMAIL VERIFICATION</button>
	</form>
</div>
@endsection
@include('layout')
