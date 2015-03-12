@extends('master')

@section('main')

<h1> Create Action </h1>

{{ Form::open(array('route'=>'actions.store')) }}

    <ul>
        <li>
            {{ Form::label('code', 'Action Code:') }}
            {{ Form::text('code') }}
        </li>
        <li>
            {{ Form::label('description', 'Description:') }}
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