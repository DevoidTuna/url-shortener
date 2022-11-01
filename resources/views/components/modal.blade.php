<head>
    <link rel="stylesheet" href="{{ URL::asset('css/modal.css'); }}">
</head>
<div class="container">
    <div class="modal">
        <h2>{{ $pageName; }}</h2>
        <div class="content">
            {{ $inputs }}
        </div>
    </div> 
</div>
<script src="{{ URL::asset('js/modal.js'); }}"></script>