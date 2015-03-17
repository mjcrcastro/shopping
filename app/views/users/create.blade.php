@extends('master')

@section('dropdown_active')
   active
@stop


@section('main')

<h1> Create User </h1>

{{ Form::open(array('route'=>'users.store')) }}

    <ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>
        <li>
            {{ Form::label('username', 'Username:') }}
            {{ Form::text('username') }}
        </li>
        
        <li>
            {{ Form::label('role', 'Role:') }}
            {{ Form::select('role_id', $roles) }}
        </li>   
        
        <li>
            {{ Form::label('password', 'Password:') }}
            {{ Form::password('password') }}
        </li>
        <li>
            {{ Form::label('password', 'Confirm Password:') }}
            {{ Form::password('password_confirmation') }}
        </li>
        <li>
            {{ Form::label('email', 'Email:') }}
            {{ Form::text('email') }}
        </li>
        <li>
            {{ Form::submit('submit', array('class'=>'btn')) }}
        </li>

    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop