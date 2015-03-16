@extends('master')

@section('brands_active')
  class= "active"
@stop

@section('main')
<h1> All Brands </h1>

<p> {{ link_to_route('brands.create', 'Add new Brand') }} </p>

@if ($brands->count())
<table class="table table-striped table-ordered table-condensed">
    <thead>
        <tr>
            <th>Brand description</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($brands as $brand)
        <tr>
            
            <td> {{ $brand->description }}  </td>
            
            <td> {{ link_to_route('brands.edit', 'Edit', array($brand->id), array('class'=>'btn btn-info')) }} </td>
            
            <td>
                {{ Form::open(array('method'=>'DELETE', 'route'=>array('generics.destroy', $brand->id))) }}
                {{ Form::submit('Delete', array('class'=>'btn btn-danger', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $brands->links() }}
@else
 There are no brands
@endif
@stop