@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="card-panel">
            <form role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="col m8">
                        <h3 class="card-title">User Registration</h3>
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="input-field col m8 {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="text" name="name" id="name" class="validate" placeholder="Name">
                        {!! $errors->has('name') ? $errors->first('name', '<span class="red-text text-darken-2">:message</span>') : '' !!}
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
                    <div class="input-field col m8 {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <input type="password" name="password_confirmation" id="password-confirm" class="validate" placeholder="Confirm Password">
                        {!! $errors->has('password_confirmation') ? $errors->first('password_confirmation', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="col m8">
                        <button type="submit" class="waves-effect waves-light btn">Register</button>
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
