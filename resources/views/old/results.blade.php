@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($results != null)
            <h2 class="mb-3">My results</h2>
            <myresults :user_id="{{ Auth::id() }}"></myresults>
            @else
            <h2>You have not passed any quizzes yet :(</h2>
            @endif
        </div>
    </div>
</div>
@endsection
