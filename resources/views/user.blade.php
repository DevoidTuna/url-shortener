@section('content')

<x-modal >
    <x-slot:inputs>
        <form action="POST">
            <input type="button" value="abc">
            <input type="checkbox" name="" id="">
            <input type="color" name="" id="">
            <input type="date" name="" id="">
            <input type="datetime-local" name="" id="">
            <input type="email" name="" id="">
            <input type="file" name="" id="">
            <input type="hidden" name="">
            <input type="image" src="" alt="">
            <input type="number" name="" id="">
            <input type="password" name="" id="">
            <input type="radio" name="" id="">
            <input type="range" name="" id="">
            <input type="search" name="" id="">
            <input type="text" name="" id="">
            <input type="time" name="" id="">
            <input type="url" name="" id="">
            <input type="week" name="" id="">
        </form>
        
    </x-slot>
</x-modal> 


@endsection
@include('layout')