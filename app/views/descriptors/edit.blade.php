@extends('master')

@section('config_active')
    active
@stop

@section('header')

@stop

@section('main')

<h1> Edit descriptor </h1>


{{ Form::model($descriptor, array('method'=>'PATCH', 'route'=> array('descriptors.update', $descriptor->id)))  }}

<dl class="dl-horizontal">
    <dt>
    {{ Form::label('description', 'Description:') }}
    </dt>
    <dd>
        {{ Form::text('description') }}
    </dd>
    <dt>
        {{ Form::label('descriptorType', 'Descriptor Type:') }}
    </dt>
    <dd>
        {{ Form::select('descriptorType_id', $descriptorsTypes) }}
    </dd>
    <dt>
    {{ Form::submit('submit', array('class'=>'btn')) }}
    </dt>

</dl>
{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop