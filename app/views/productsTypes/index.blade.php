@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
    active
@stop

@section('main')

    <h1> All products types </h1>

    <p> {{ link_to_route('productsTypes.create', 'Add new product type') }} </p>

    @if ($productsTypes->count())
        <table class="table table-striped table-ordered">
            <thead>
                <tr>
                    <th>Product Type Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productsTypes as $productType)
                <tr>
                    <td> {{ $productType->description }}  </td>

                    <td> {{ link_to_route('productsTypes.edit', 'Edit', array($productType->id), array('class'=>'btn btn-info '.Config::get('global/default.button_size'))) }}  </td>
                    
                    <td>
                        {{ Form::open(array('method'=>'DELETE', 'route'=>array('productsTypes.destroy', $productType->id))) }}
                        {{ Form::submit('Delete', array('class'=>'btn btn-danger '.Config::get('global/default.button_size'), 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $productsTypes->links() }}  {{-- code at the left is for breadcrumbes --}}
    @else
        There are no products types
    @endif
    
@stop {{-- End of section main --}}