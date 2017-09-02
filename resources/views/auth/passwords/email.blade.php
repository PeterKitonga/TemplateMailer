@extends('layouts.app')

<!-- Main Content -->
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

            <form role="form" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="col m8">
                        <h3 class="card-title">Forgot Password?</h3>
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="input-field col m8 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="email" name="email" id="email" class="validate" placeholder="Email Address" value="{{ old('email') }}">
                        {!! $errors->has('email') ? $errors->first('email', '<span class="red-text text-darken-2">:message</span>') : '' !!}
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>

                <div class="row">
                    <div class="col m1 offset-m1"></div>
                    <div class="col m8">
                        <button type="submit" class="waves-effect waves-light btn">Send Reset Email</button>
                    </div>
                    <div class="col m1 offset-m1"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
