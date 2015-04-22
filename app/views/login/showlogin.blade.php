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
            {{ Form::text('username',null,array('class'=>'form-control')) }}
        </p>

        <p>
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password',array('class'=>'form-control')) }}
        </p>

        <p>{{ Form::submit('Submit!',array('class'=>'form-control btn btn-primary')) }}</p>
    {{ Form::close() }}


@stop       