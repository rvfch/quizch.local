@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($error != "private")
            <h2 class="mb-3">Quiz #{{ $id }}</h2>
            <quiz :quiz_id="{{ $id }}"></quiz>
            @else
            <h2>You don't have access to this quiz :(</h2>
            @endif
        </div>
    </div>
</div>
@endsection
