@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    
        <div class="col-md-12">
        <h2 class="mb-3">New quiz</h2>
            <newquiz :user_id="{{ Auth::id() }}"></newquiz>
        </div>
    </div>
</div>
@endsection
