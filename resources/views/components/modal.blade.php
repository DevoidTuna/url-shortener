<head>
    @vite(['resources/css/modal.css', 'resources/js/modal.js'])
</head>
<div class="container" id="{{$idModal}}">
    <div class="modal">
        <h2>{{ $pageName; }}</h2>
        <div class="content">
            {{ $inputs }}
        </div>
    </div> 
</div>
