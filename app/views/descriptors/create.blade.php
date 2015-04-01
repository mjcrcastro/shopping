@extends('master')

@section('config_active')
    active
@stop

@section('main')

<h1> Create {{ $label }} descriptor</h1>

    {{ Form::open(array('route'=>'descriptors.store','class'=>'horizontal','role'=>'form')) }}

    <div class="form-group">

            <li>
            {{ Form::label('description', 'Description:') }}
                {{ Form::text('description') }}
            </li>
            
            <li>
            {{ Form::label('DescriptorType', 'Descriptor Type:') }}
            {{ Form::select('descriptorType_id', $descriptorsTypes, $descriptorType_id) }}
            </li>   
            
            <li>
            {{ Form::submit('submit', array('class'=>'btn')) }}
            </li>
    </div>

    {{ Form::close() }}

    @if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
    @endif

@stop
