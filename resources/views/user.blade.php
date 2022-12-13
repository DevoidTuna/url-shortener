<!DOCTYPE html>
@section('content')
<head>
    @vite(['resources/css/user.css', 'resources/js/user.js'])
</head>

@if(Route::is('page.user.index') )
<head>
    <title>My Profile - Dev.ly</title>
</head>

<div class="bodyContainer">
<button type="button" id="buttonModal">Create URL <img src="{{ Vite::asset('public/midia/add-to-list.png'); }}"  alt="add link" class="img-add-to-list icon"></button>
    <x-modal pageName='Create URL' class="modal" idModal="{{$modalCreateUrl}}">
        <x-slot:inputs>
            <form method="POST" action="{{ route('do-create-url') }}" id="formCreateUrl">
                @csrf
                <div id="generateUrl">
                    <div class="field">
                        <label for="nameUrl" class="title">name (way that will be saved in your profile)</label>
                        <input type="text" id="nameUrl" name="nameUrl" placeholder="optional">
                    </div>
                    <div class="field">
                        <label for="destinationUrl" class="title">URL</label>
                        <input type="text" id="destinationUrl" name="destinationUrl" placeholder="required" required>
                        <span id="span-destinationUrl">Please insert a valid URL.</span>
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
                        <button type="button" id="generateUrlButton" disabled>shorten url</button>
                    </div>
                </div>
            </form>
            <button class="closeModalButton">close</button>
        </x-slot:inputs>
    </x-modal>
    <h2 class="title title-myUrls"><img src="{{ Vite::asset('public/midia/link.png'); }}"  alt="my urls" class="img-link icon">My URLs</h2>
    @foreach ($urls as $urls)
    <div class="field-shortened-url">
        <button class="button-copyUrl"><img src="{{ Vite::asset('public/midia/copy.png'); }}" alt="copy url"></button>
        <div class="box box-shortened-url">
            <div class="field-box field-goUrl">
                @if (!$urls->public)
                <img src="{{ Vite::asset('public/midia/padlock.png'); }}" alt="private link" class="img-isPublic icon">
                @else
                <img src="{{ Vite::asset('public/midia/public.png'); }}" alt="private link" class="img-isPublic icon">
                @endif
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
                <form method="POST" action="{{route('delete-url')}}" class="field-shortened-url delete-button">
                    @csrf
                    <button type="submit" name="link_id" value="{{$urls->id}}" class="button-deleteUrl"><img src="{{ Vite::asset('public/midia/delete.png'); }}" alt="Delete URL"class="img-delete"></button>    
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@if(Route::is('page.user.show'))
    <head>
        <title>{{ mb_convert_case($userName[0]->name, MB_CASE_TITLE, 'UTF-8') }} URLs - Dev.ly</title>
    </head>

    <div class="bodyContainer">
        @if (sizeof($userUrls) == 0)
            <h2 class="title title-myUrls"><img src="{{ Vite::asset('public/midia/link.png'); }}"  alt="my urls" class="img-link icon">{{ mb_convert_case($userName[0]->name, MB_CASE_TITLE, 'UTF-8') }} has no active URLs currently.</h2>
        @else
        <h2 class="title title-myUrls"><img src="{{ Vite::asset('public/midia/link.png'); }}"  alt="{{$userName[0]->name}} urls" class="img-link icon">{{ mb_convert_case($userName[0]->name, MB_CASE_TITLE, 'UTF-8') }} URLs</h2>
                @foreach ($userUrls as $userUrls)
                <div class="field-shortened-url">
                    <button class="button-copyUrl"><img src="{{ Vite::asset('public/midia/copy.png'); }}" alt="Copy short link"></button>
                    <div class="box box-shortened-url">
                        <div class="field-box field-goUrl">
                            <img src="{{ Vite::asset('public/midia/public.png'); }}" alt="private link" class="img-isPublic icon">
                            <h3>
                                @if ($userUrls->name_link == null)
                                <a href="{{ $userUrls->recipient_link }}" value="{{ $site . $userUrls->shortened_link }}" target="_blank" class="goToUrl">{{ $userUrls->recipient_link }}</a>
                                @else
                                <a href="{{ $userUrls->recipient_link }}" value="{{ $site . $userUrls->shortened_link }}" target="_blank" class="goToUrl">{{ ucwords($userUrls->name_link) }}</a>
                                @endif
                                <span class="divisor"></span>
                            </h3>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endif
@endsection
@include('layout')
