<!DOCTYPE html>
@section('content')
<head>
    @vite('resources/css/index.css')
    <title>Dev.ly - URL Shortener</title>
</head>
<div class="bodyImg">
    <img src="{{Vite::asset('public/favicon.ico');}}" alt="" id="logo">
</div>
<div class="index-content">
    <div class="text">
        <h2 class="title">Dev.ly. A simple URL shortener.</h2>
        <br>
        <p>A personalized URL shortening platform, with profiles containing URLs set as public and not yet expired. Click the button below to start creating shortened URLs or create your registration.</p>
    </div>
    <div class="buttonStartNow">
        <a href="{{ route('page.user.index')}}">
            <button class="btnStartNow">Start now</button>
        </a>
    </div>
</div>
@endsection
@include('layout')
