@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="card-panel">
            <form role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="col m8">
                        <h3 class="card-title">User Login</h3>
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="input-field col m8 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="email" name="email" id="email" class="validate" placeholder="Email Address">
                        {!! $errors->has('email') ? $errors->first('email', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="input-field col m8 {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password" id="password" class="validate" placeholder="Password">
                        {!! $errors->has('password') ? $errors->first('password', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <p class="col m8">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : ''}} />
                        <label for="remember">Remember Me</label>
                    </p>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <a class="col m8" href="{{ url('/password/reset') }}">
                        Forgot Your Password?
                    </a>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="col m8">
                        <button type="submit" class="waves-effect waves-light btn">Login</button>
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
