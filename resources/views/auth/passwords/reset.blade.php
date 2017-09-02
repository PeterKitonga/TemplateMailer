@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="card-panel">
            @if (session('status'))
                <div class="row">
                    <div class="card-panel">
                        <span class="blue-text text-darken-2">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <form role="form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="col m8">
                        <h3 class="card-title">Reset Your Password</h3>
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="input-field col m8 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="email" name="email" id="email" class="validate" placeholder="Email Address" value="{{ $email or old('email') }}">
                        {!! $errors->has('email') ? $errors->first('email', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>
                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="input-field col m8 {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password" id="password" class="validate" placeholder="New Password">
                        {!! $errors->has('password') ? $errors->first('password', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="input-field col m8 {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <input type="password" name="password_confirmation" id="password-confirm" class="validate" placeholder="Confirm New Password">
                        {!! $errors->has('password_confirmation') ? $errors->first('password_confirmation', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="col m8">
                        <button type="submit" class="waves-effect waves-light btn">Reset Password</button>
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
