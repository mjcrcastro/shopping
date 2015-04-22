@extends('master')

@section('dropdown_active')
active
@stop


@section('main')

<h1> Edit User </h1>

<div class="container container-fluid">
    <div class="row">
        <div class="col-xs-12">
            {{ Form::model($user, array('method'=>'PATCH', 'route'=> array('users.update', $user->id)))  }}


            {{ Form::label('username', 'Username:') }}
            {{ Form::label('username_text', $user->username, array('class'=>'form-control')) }}

            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name',null,  array('class'=>'form-control')) }}

            {{ Form::label('email', 'Email:') }}
            {{ Form::text('email', null,  array('class'=>'form-control')) }}

            {{ Form::label('name', 'Name:') }}
            {{ Form::select('role_id', $roles, null, array('class'=>'form-control')) }}
        </div>
    </div>
    <p></p>
    <div class="row">
        <div class="col-xs-6">
            {{ Form::submit('Update', array('class'=>'btn btn-primary btn-block')) }}
        </div>
        <div class="col-xs-6">
            {{ link_to_route('users.index', 'Cancel', null, array('class'=>'btn btn-info btn-block')) }}
        </div>
    </div>
</div>

{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop