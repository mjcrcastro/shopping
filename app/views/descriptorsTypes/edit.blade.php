@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
    class="active"
@stop

@section('main')

<h1> Edit Descriptor type </h1>


{{ Form::model($descriptorType, array('method'=>'PATCH', 'route'=> array('descriptorsTypes.update', $descriptorType->id)))  }}

    <ul>
        
        <li>
            {{ Form::label('description', 'Description:') }}
            {{ Form::text('description') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class'=>'btn btn-info')) }}
            {{ link_to_route('descriptorsTypes.index', 'cancel', $descriptorType->id, array('class'=>'btn')) }}
        </li>

    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop