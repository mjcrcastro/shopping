@extends('master')

@section('dropdown_active')
   active
@stop


@section('main')

<h1> Edit User </h1>


{{ Form::model($user, array('method'=>'PATCH', 'route'=> array('users.update', $user->id)))  }}

    <ul>
        
        <li>
            {{ Form::label('username', 'Username:') }}
            {{ Form::label('username_text', $user->username) }}
        </li>
        
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>
        
        <li>
            {{ Form::label('email', 'Email:') }}
            {{ Form::text('email') }}
        </li>

        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::select('role_id', $roles) }}
        </li>    
      
        <li>
            {{ Form::submit('Update', array('class'=>'btn btn-info')) }}
            {{ link_to_route('users.index', 'Cancel', [],array('class'=>'btn btn-info')) }}
        </li>

    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop