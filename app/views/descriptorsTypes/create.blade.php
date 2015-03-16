@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
    active
@stop


@section('main')

<h1> Create Descriptor type </h1>

{{ Form::open(array('route'=>'descriptorsTypes.store')) }}

    <ul>
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