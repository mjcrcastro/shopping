@extends('master')

@section('dropdown_active')
   class = "active"
@stop


@section('main')

<h1> Create Role </h1>

{{ Form::open(array('route'=>'roles.store')) }}

    <ul>
        <li>
            {{ Form::label('description', 'Role Description:') }}
            {{ Form::text('description') }}
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