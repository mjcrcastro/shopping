@extends('master')

@section('config_active')
    active
@stop

@section('main')

<h1> Create descriptor {{ $label }} </h1>

    {{ Form::open(array('route'=>'descriptors.store','class'=>'vertical','role'=>'form')) }}

    <div class="form-group">

            {{ Form::label('description', 'Description:') }}
            {{ Form::text('description', null, array('class="form-control"')) }}
            
            {{ Form::label('DescriptorType', 'Descriptor Type:') }}
            {{ Form::select('descriptorType_id', $descriptorsTypes, $descriptorType_id, array('class="form-control"')) }}
            <p></p>
            {{ Form::submit('Submit', array('class'=>'btn btn-default')) }}
    </div>

    {{ Form::close() }}

    @if ($errors->any())
        {{ implode('',$errors->all('<div class="alert alert-danger" role="alert">'
                    .'<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'
                    .'<span class="sr-only">Error:</span>:message</div>')) }}
    @endif

@stop
