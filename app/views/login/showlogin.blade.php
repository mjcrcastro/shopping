@extends('master')

@section('main')

    {{ Form::open(array('url'=>'login')) }}
        <h1>Login</h1>

        <!-- if there are login errors, show them here -->
        <!-- Session::get is to get an incoming message from LoginController -->
        <p>
                {{ Session::get('message') }}
                {{ $errors->first('username') }}
                {{ $errors->first('password') }}
        </p>

        <p>
            {{ Form::label('username', 'Username') }}
            {{ Form::text('username') }}
        </p>

        <p>
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password') }}
        </p>

        <p>{{ Form::submit('Submit!') }}</p>
    {{ Form::close() }}


@stop       