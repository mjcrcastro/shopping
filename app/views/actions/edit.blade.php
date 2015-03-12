@extends('master')

@section('main')

<h1> Edit Action </h1>


{{ Form::model($action, array('method'=>'PATCH', 'route'=> array('actions.update', $action->id)))  }}

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
            {{ Form::submit('Update', array('class'=>'btn btn-info')) }}
            {{ link_to_route('actions.index', 'cancel', $action->id, array('class'=>'btn')) }}
        </li>

    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop