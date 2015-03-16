@extends('master')

@section('dropdown_active')
   active
@stop

@section('main')

    @if (count($permissions))

    <h1> Edit Permissions for {{ $role_name }}</h1>

    {{ Form::open(array('method'=>'PATCH', 'route'=> array('permissions.update', $id, )))  }}
    <table class="table table-striped table-ordered">
        <thead>
            <tr>
                <th>Action Description</th>
                <th>Selected</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>


            @foreach ($permissions as $permission)
            <tr>
                <td>
                    {{ $permission->description }}
                </td>

                <td>    
                {{ Form::checkbox('actions[]',$permission->action_id, is_null($permission->role_id)<>true) }}
                </td>
            </tr>
            @endforeach


        </tbody>
    </table>
    {{ Form::submit('Update', array('class'=>'btn btn-info')) }}
    {{ link_to_route('roles.index', 'cancel') }}
    {{ Form::close() }}
    @else
          There are no Permissions for {{ Role::find($id)->description }}
    @endif

    @if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
    @endif

@stop