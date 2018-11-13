@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($error === "0")
            <h2 class="mb-3">Quiz #{{ $id }}</h2>
            <quiz :quiz_id="{{ $id }}" :user_id="{{ Auth::id() }}"></quiz>
            @elseif ($error === "dontexist")
            <h2>Quiz don't exist :(</h2>
            @elseif ($error === "passed")
            <h2>You already passed this quiz :(</h2>
            @elseif ($error === "private")
            <h2>You don't have access to this quiz :(</h2>
            @endif
        </div>
    </div>
</div>
@endsection
