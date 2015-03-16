@extends('master')

@section('config_active')
    active
@stop

@section('main')

<h1> Create {{ DescriptorType::find($descriptorType_id)->description }} descriptor</h1>

    {{ Form::open(array('route'=>'descriptors.store','class'=>'horizontal','role'=>'form')) }}

    <div class="form-group">

            <dt>
            {{ Form::label('description', 'Description:') }}
            </dt>
            <dd>
                {{ Form::text('description') }}
            </dd>
            
            <dd>
                {{ Form::hidden('descriptorType_id', $descriptorType_id) }}
            </dd>
            
            <dt>
            {{ Form::submit('submit', array('class'=>'btn')) }}
            </dt>
    </div>

    {{ Form::close() }}

    @if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
    @endif

@stop
