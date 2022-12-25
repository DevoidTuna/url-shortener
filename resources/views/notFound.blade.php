<!DOCTYPE html>

@section('content')
<div class="bodyContainer">
    <h2>{{ $errorMessage }}</h2>
    <h2>Return <a href="{{route('page.index')}}">Home</a>.</h2>
</div>

@endsection
@include('layout')
<head>
    <title>Page Not Found</title>
    <style>
        a {
            text-decoration: none;
        }
        .bodyContainer {
            text-align: center;
            width: max-content;
            margin: 100px auto;
            font-size: 25px;
        }
    </style>
</head>
