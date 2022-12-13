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
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium placeat molestias, beatae quam dolorem consequuntur magnam animi laborum sit nesciunt dolores nisi optio deserunt officia mollitia consequatur autem, velit nemo.</p>
    </div>
    <div class="buttonStartNow">
        <a href="{{ route('page.user.index')}}">
            <button class="btnStartNow">Start now</button>
        </a>
    </div>
</div>
@endsection
@include('layout')