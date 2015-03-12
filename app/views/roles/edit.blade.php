

@extends('master')

@section('dropdown_role')
    class = "active"
@stop

@section('main')

<h1> Edit role </h1>


{{ Form::model($role, array('method'=>'PATCH', 'route'=> array('inventions.update', $role->id)))  }}

<dl class="dl-horizontal">
    
    <dt>
    {{ Form::label('description', 'Description:') }}
    </dt>
    <dd>
        {{ Form::text('docket_number') }}
    </dd>
                {{ Form::submit('submit', array('class'=>'btn')) }}
</dl>
{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop