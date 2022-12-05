<!DOCTYPE html>
@section('content')
<h2>{{ $errorMessage }}</h2>
<h2>Return <a href="{{redirect()->back()}}">back</a> or <a href="{{route('page.index')}}">Home</a>.</h2>
@endsection
@include('layout')