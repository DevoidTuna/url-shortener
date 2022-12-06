<!DOCTYPE html>
@section('content')
<head>
    @vite(['resources/css/editProfile.css', 'resources/js/editProfile.js'])
</head>
@auth
<div class="bodyContent">
    <h2>Edit user settings.</h2>
    <form action="{{ route('do-edit-user') }}" method="post">
        @csrf
        <div id="boxes-container">
            <div class="box">
                <label for="edit-name">Name:</label>
                <input type="text" name="name" id="edit-name" value="{{$user->name}}">
                <span id="span-name">Your name need to have 3 or more letters</span>
            </div>
            <div class="box">
                <label for="edit-email">E-mail:</label>
                <input type="text" name="email" id="edit-email" value="{{$user->email}}">
                <span id="span-email">This email address isn't valid</span>
            </div>
            <div class="box">
                <label for="edit-password">New password:</label>
                <input type="password" name="newPassword" id="edit-password" placeholder="min 6 letters">
                <span id="span-password">The password must be 6 or more characters</span>
            </div>
            <div class="successMessage">
                User settings updated!
            </div>
            <div class="bottom-buttons">
                <button type="button" name="btn-updateProfile" id="btn-updateProfile">Save Changes</button>
            </div>
        </div>
    </form>
</div>
@endauth

@endsection
@include('layout')