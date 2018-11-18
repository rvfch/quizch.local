@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($quizzes != null)
            <h2 class="mb-3">My quizzes</h2>
            <myquizzes :user_id="{{ Auth::id() }}"></myquizzes>
            @else
            <h2>You have not created any quizzes yet :(</h2>
            @endif
        </div>
    </div>
</div>
@endsection
