@extends('master')

@section('dropdown_active')
 active
@stop

@section('main')
<h1> All Actions </h1>

<p> {{ link_to_route('actions.create', 'Add new Action') }} </p>

@if ($actions->count())
<table class="table table-striped table-ordered">
    <thead>
        <tr>
            <th>Action Code</th>
            <th>Action Description</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($actions as $action)
        <tr>
            <td> {{ $action->code }}  </td>
            <td> {{ $action->description }}  </td>

            <td> {{ link_to_route('actions.edit', 'Edit', array($action->id), array('class'=>'btn btn-info')) }} </td>


            <td>
                {{ Form::open(array('method'=>'DELETE', 'route'=>array('actions.destroy', $action->id))) }}
                {{ Form::submit('Delete', array('class'=>'btn btn-danger', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $actions->links() }}
@else
 There are no Actions
@endif
@stop