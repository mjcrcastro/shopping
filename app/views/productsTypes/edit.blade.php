@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
    active
@stop

@section('main')

<h1> Edit Product type </h1>


{{ Form::model($productType, array('method'=>'PATCH', 'route'=> array('productsTypes.update', $productType->id)))  }}

    <ul>
        
        <li>
            {{ Form::label('description', 'Description:') }}
            {{ Form::text('description') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class'=>'btn btn-info')) }}
            {{ link_to_route('productsTypes.index', 'cancel', $productType->id, array('class'=>'btn')) }}
        </li>

    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop