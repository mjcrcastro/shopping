@extends('master')

@section('config_active')
   class = "active"
@stop


@section('main')

<h1> Create Generic name </h1>

{{ Form::open(array('route'=>'generics.store')) }}

    <ul>
        <li>
            {{ Form::label('description', 'Generic Name:') }}
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