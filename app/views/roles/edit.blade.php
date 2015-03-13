

@extends('master')

@section('dropdown_role')
    class = "active"
@stop

@section('main')

<h1> Edit role </h1>


{{ Form::model($role, array('method'=>'PATCH', 'route'=> array('roles.update', $role->id)))  }}

    <ul>
        
        <li>
            {{ Form::label('description', 'Role Description:') }}
            {{ Form::text('description') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class'=>'btn btn-info')) }}
            {{ link_to_route('roles.index', 'cancel', $role->id, array('class'=>'btn')) }}
        </li>

    </ul>
{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop