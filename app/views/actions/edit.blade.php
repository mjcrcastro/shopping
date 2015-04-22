@extends('master')

@section('main')

<h1> Edit Action </h1>


{{ Form::model($action, array('method'=>'PATCH', 'route'=> array('actions.update', $action->id)))  }}

    <ul class="list-group">
        
        <li class="list-group-item">
            {{ Form::label('code', 'Action Code:') }}
            {{ Form::text('code') }}
        </li>
        
        <li class="list-group-item">
            {{ Form::label('description', 'Description:') }}
            {{ Form::text('description') }}
        </li>

        <li class="list-group-item">
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