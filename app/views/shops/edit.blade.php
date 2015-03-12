@extends('master')

@section('main')

<h1> Edit Shop </h1>


{{ Form::model($shop, array('method'=>'PATCH', 'route'=> array('shops.update', $shop->id)))  }}

    <ul>
        
        <li>
            {{ Form::label('description', 'Shop Description:') }}
            {{ Form::text('description') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class'=>'btn btn-info')) }}
            {{ link_to_route('shops.index', 'cancel', $shop->id, array('class'=>'btn')) }}
        </li>

    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop