<!DOCTYPE html>
@section('content')
<head>
    @vite(['resources/css/user.css', 'resources/js/user.js'])
</head>

@guest
<p>You need to be logged in <a href="{{ route('page.login') }}">here</a>.</p>
@endguest

@auth
<div class="bodyContainer">
    <input type="button" value="Create URL" id="buttonModal">
    <x-modal pageName='Create URL' class="modal" idModal="{{$idModal}}">
        <x-slot:inputs>
            <form method="POST" action="{{ route('do-create-url') }}">
                @csrf
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
                            <input value="-1" type="radio" id="avaliableTime-noExpiration" name="expiration" checked>
                            <label for="avaliableTime-noExpiration">no expiration</label>
                            <input value="15" type="radio" id="avaliableTime-15minutes" name="expiration">
                            <label for="avaliableTime-15minutes">15 minutes</label>
                            <input value="30" type="radio" id="avaliableTime-30minutes" name="expiration">
                            <label for="avaliableTime-30minutes">30 minutes</label>
                            <input value="60" type="radio" id="avaliableTime-60minutes" name="expiration">
                            <label for="avaliableTime-60minutes">1 hour</label>
                        </div>
                    </div>
                    <div class="field radio">
                        <label class="title">visibility (in your profile)</label>
                        <div>
                            <input value="true" type="radio" id="visibility-public" name="public" checked>
                            <label for="visibility-public">public</label>
                            <input value="false" type="radio" id="visibility-private" name="public">
                            <label for="visibility-private">private</label>
                        </div>
                    </div>
                    <div class="field generate-button">
                        <button id="generateUrlButton" disabled>shorten url</button>
                    </div>
                </div>
            </form>
            <button class="closeButton">close</button>
        </x-slot:inputs>
    </x-modal>
    <h2>My URLs</h2>
    @foreach ($urls as $urls)
    <div class="field-shortened-url">
        <button class="button-copyUrl"><img src="{{ Vite::asset('public/midia/copy.png'); }}" alt=""></button>
        <div class="box box-shortened-url">
            <div class="field-box field-goUrl">
                @if (!$urls->public)
                <img src="{{ Vite::asset('public/midia/padlock.png'); }}" alt="private link" class="img-padlock icon">
                @endif
                <img src="{{ Vite::asset('public/midia/external-link.png'); }}" alt="Go to link" class="img-external-link icon">
                <h3>
                    @if ($urls->name_link == null)
                    <a href="{{ $urls->recipient_link }}" value="{{ $site . $urls->shortened_link }}" target="_blank" class="goToUrl">{{ $urls->recipient_link }}</a>
                    @else
                    <a href="{{ $urls->recipient_link }}" value="{{ $site . $urls->shortened_link }}" target="_blank" class="goToUrl">{{ ucwords($urls->name_link) }}</a>
                    @endif
                </h3>
            </div>
            <div class="field-box">
                <span class="divisor">|</span>
                <form method="POST" action="{{route('delete-url')}}" class="field-shortened-url">
                    @csrf
                    <button type="submit" name="link_id" value="{{$urls->id}}" class="button-deleteUrl"><img src="{{ Vite::asset('public/midia/delete.png'); }}" alt="Delete URL"class="img-delete icon"></button>    
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endauth
@endsection
@include('layout')
