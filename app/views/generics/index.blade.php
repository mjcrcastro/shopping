@extends('master')

@section('generics_active')
  class= "active"
@stop

@section('main')
<h1> All Generic Names </h1>

<p> {{ link_to_route('generics.create', 'Add new Generic name') }} </p>

@if ($generics->count())
<table class="table table-striped table-ordered table-condensed">
    <thead>
        <tr>
            <th>Generic Name</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($generics as $generic)
        <tr>
            
            <td> {{ $generic->description }}  </td>
            
            <td> {{ link_to_route('generics.edit', 'Edit', array($generic->id), array('class'=>'btn btn-info')) }} </td>
            
            <td>
                {{ Form::open(array('method'=>'DELETE', 'route'=>array('generics.destroy', $generic->id))) }}
                {{ Form::submit('Delete', array('class'=>'btn btn-danger', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $generics->links() }}
@else
 There are no generics
@endif
@stop