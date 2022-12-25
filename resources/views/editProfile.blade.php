<!DOCTYPE html>
@section('content')
<head>
    @vite(['resources/css/editProfile.css', 'resources/js/editProfile.js'])
    <title>Edit Account Settings - Dev.ly</title>
</head>
@auth
<div class="bodyContent">
    <h2>Edit user settings.</h2>
    <form action="{{ route('do-edit-user') }}" method="post" id="formEditUser">
        @csrf
        <div id="boxes-container">
            <div class="box">
                <label for="edit-name">Name:</label>
                <input type="text" name="name" id="edit-name" value="{{$user->name}}">
                <span class="spanError" id="span-name">Your name need to have 3 or more letters</span>
            </div>
            <div class="box">
                <label for="edit-email">E-mail:</label>
                <input type="text" name="email" id="edit-email" value="{{$user->email}}">
                <span class="spanError" id="span-email">This email address isn't valid</span>
            </div>
            <div class="successMessage">
                User settings updated!
            </div>
            <div class="bottom-buttons">
                <button type="button" name="btn-updateProfile" id="btn-updateProfile">Save Changes</button>
            </div>
        </div>
    </form>
    <form action="{{ route('do-update-password') }}" method="post" id="formUpdatePassword">
        @csrf
        <div class="box">
            <div class="box-edit-password">
                <label for="edit-password">New password:</label>
                <input type="password" name="newPassword" id="edit-password" placeholder="min 6 letters">
                <button type="button" name="btn-updatePassword" id="btn-updatePassword" {{$disabled}}>Update Password</button>
            </div>
            <div class="display-block">
                <span class="spanError" id="span-password">The password must be 6 or more characters</span>
                @if ($passwordUpdate == true)
                <div class="successMessage" id="spanSuccessUpdatePassword">User password updated!</div>
                @endif
            </div>
        </div>
    </form>
</div>
@endauth
@endsection
@include('layout')
