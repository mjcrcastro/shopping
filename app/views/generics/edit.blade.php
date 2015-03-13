

@extends('master')

@section('dropdown_config')
    class = "active"
@stop

@section('main')

<h1> Edit Generic Name </h1>


{{ Form::model($generic, array('method'=>'PATCH', 'route'=> array('generics.update', $generic->id)))  }}

    <ul>
        
        <li>
            {{ Form::label('description', 'Role Description:') }}
            {{ Form::text('description') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class'=>'btn btn-info')) }}
            {{ link_to_route('generics.index', 'Cancel', [],array('class'=>'btn btn-info')) }}
        </li>

    </ul>
{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop