@extends('spa')

@section('content')
<main class="text-center auth">
  <form method="POST" action="{{ route('login') }}" class="form-signin">
      @csrf
      <h1 class="h3 mb-3 font-weight-normal">Quizch</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" name="email" class="form-control" placeholder="{{ __('E-Mail Address') }}" required autofocus/>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" id="inputPassword" class="form-control" placeholder="{{ __('Password') }}" required />
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; Rvfch</p>
  </form>
</main>
@endsection
