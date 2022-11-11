@section('content')
<head>
    @vite(['resources/css/user.css', 'resources/js/user.js'])
</head>
<input type="button" value="open modal" id="buttonModal">
<x-modal pageName='Create URL' class="modal" idModal="{{$idModal}}">
    <x-slot:inputs>
        <form method="POST" action="">
            <div class="field">
                <label for="destinationUrl">URL</label>
                <input type="url" id="destinationUrl" name="destinationUrl" oninput="check()" required>
            </div>
            <div class="field radio">
                <label class="title">Avaliable time</label>
                <div>
                    <input type="radio" id="avaliableTime-noExpiration" name="avaliableTime" checked>
                    <label for="avaliableTime-noExpiration">No expiration</label>
                    <input type="radio" id="avaliableTime-15minutes" name="avaliableTime">
                    <label for="avaliableTime-15minutes">15 minutes</label>
                    <input type="radio" id="avaliableTime-30minutes" name="avaliableTime">
                    <label for="avaliableTime-30minutes">30 minutes</label>
                    <input type="radio" id="avaliableTime-60minutes" name="avaliableTime">
                    <label for="avaliableTime-60minutes">1 hour</label>
                </div>
            </div>
            <div class="field radio">
                <label class="title">Visibility (in your profile)</label>
                <div>
                    <input type="radio" id="visibility-public" name="visibility" checked>
                    <label for="visibility-public">public</label>
                    <input type="radio" id="visibility-private" name="visibility">
                    <label for="visibility-private">private</label>
                </div>
            </div>
            <div class="field generate-button">
                <button type="submit" id="generateUrlButton" disabled>generate shortened url</button>
            </div>
            <div class="field shortenedUrl">
                <label for="shortenedUrl" class="title">shortened URL</label>
                <div class="displayFlex">
                    <input type="text" name="shortenedUrl" id="shortenedUrl" readonly>
                    <button id="copyButton" disabled>copy</button>
                </div>
            </div>
        </form>
    </x-slot:inputs>
</x-modal>
@endsection
@include('layout')
