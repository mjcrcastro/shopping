@extends('master')

@section('dropdown_active')
  active
@stop

@section('main')
<h1> All Roles </h1>

<p> {{ link_to_route('roles.create', 'Add new role') }} </p>

@if ($roles->count())
<table class="table table-striped table-ordered table-condensed">
    <thead>
        <tr>
            <th>Role Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $role)
        <tr>
            <td> {{ $role->description }} ( is allowed {{ $role->permissions->count() }} permissions )  </td>

            <td> {{ link_to_route('roles.edit', 'Edit', array($role->id), array('class'=>'btn btn-info')) }} </td>
            
            <td> {{ link_to_route('permissions.edit', 'Permissions', array($role->id), array('class'=>'btn btn-info')) }} </td>

            <td>
                {{ Form::open(array('method'=>'DELETE', 'route'=>array('roles.destroy', $role->id))) }}
                {{ Form::submit('Delete', array('class'=>'btn btn-danger', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $roles->links() }}
@else
 There are no roles
@endif
@stop