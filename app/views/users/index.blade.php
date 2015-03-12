@extends('master')

@section('dropdown_active')
   class = "active"
@stop


@section('main')
<h1> All users </h1>

<p> {{ link_to_route('users.create', 'Add new user') }} </p>

@if ($users->count())
<table class="table table-striped table-ordered">
    <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>email</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td> {{ $user->username }}  </td>
            <td> {{ $user->name }}  </td>
            <td> {{ $user->email }}  </td>

            <td> {{ link_to_route('users.edit', 'Edit', array($user->id), array('class'=>'btn btn-info')) }} </td>


            <td>
                {{ Form::open(array( 'method'=>'DELETE', 'route'=>array('users.destroy', $user->id))) }}
                {{ Form::submit('Delete', array('class'=>'btn btn-danger', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }} 
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
 There are no users
@endif
@stop