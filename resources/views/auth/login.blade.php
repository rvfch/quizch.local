@extends('spa')

@section('content')
<main class="animated zoomIn fast auth">
    <section>
        <div class="content">
          <div class="logo text-center">
            Welcome
          </div>
            <form method="POST" action="{{ route('login') }}" class="form-full" autocomplete="off">
                @csrf
                <div class="form-row">
                    <input type="email" name="email" placeholder="{{ __('E-Mail Address') }}" required autofocus/>
                </div>
                <div class="form-row">
                    <input type="password" name="password" placeholder="{{ __('Password') }}" required />
                </div>
                <div class="form-row">
                    <button type="submit" class="btn btn-blue">Log In</button>
                </div>
            </form>

            <button type="button" class="btn btn-green btn-lg">Sign Up</button>
        </div>
    </section>
</main>
@endsection
