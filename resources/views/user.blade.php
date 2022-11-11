<!DOCTYPE html>
@section('content')
<head>
    @vite(['resources/css/user.css', 'resources/js/user.js'])
</head>

@guest
<p>You need to be logged in <a href="{{ route('page.login') }}">here</a>.</p>
@endguest

@auth
<input type="button" value="open modal" id="buttonModal">
<x-modal pageName='Create URL' class="modal" idModal="{{$idModal}}">
    <x-slot:inputs>
        {{-- <form> --}}
            <div id="generateUrl">
                <div class="field">
                    <label for="nameUrl" class="title">name (way that will be saved in your profile)</label>
                    <input type="text" id="nameUrl" name="nameUrl" placeholder="optional">
                </div>
                <div class="field">
                    <label for="destinationUrl" class="title">URL</label>
                    <input type="text" id="destinationUrl" name="destinationUrl" placeholder="required" required>
                </div>
                <div class="field radio">
                    <label class="title">avaliable time</label>
                    <div>
                        <input type="radio" id="avaliableTime-noExpiration" name="avaliableTime" checked>
                        <label for="avaliableTime-noExpiration">no expiration</label>
                        <input type="radio" id="avaliableTime-15minutes" name="avaliableTime">
                        <label for="avaliableTime-15minutes">15 minutes</label>
                        <input type="radio" id="avaliableTime-30minutes" name="avaliableTime">
                        <label for="avaliableTime-30minutes">30 minutes</label>
                        <input type="radio" id="avaliableTime-60minutes" name="avaliableTime">
                        <label for="avaliableTime-60minutes">1 hour</label>
                    </div>
                </div>
                <div class="field radio">
                    <label class="title">visibility (in your profile)</label>
                    <div>
                        <input type="radio" id="visibility-public" name="visibility" checked>
                        <label for="visibility-public">public</label>
                        <input type="radio" id="visibility-private" name="visibility">
                        <label for="visibility-private">private</label>
                    </div>
                </div>
                <div class="field generate-button">
                    <button id="generateUrlButton" disabled>generate shortened url</button>
                </div>
            </div>
        {{-- </form> --}}
        <div class="field field-shortenedUrl">
            <label for="shortenedUrl" class="title">shortened URL</label>
            <div class="displayFlex">
                <input type="text" name="shortenedUrl" id="shortenedUrl" >
                <button id="copyButton">copy</button>
            </div>
        </div>
        <button class="closeButton">close</button>
    </x-slot:inputs>
</x-modal>
@endauth
@endsection
@include('layout')
