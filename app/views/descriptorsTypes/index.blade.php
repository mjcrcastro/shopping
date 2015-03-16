@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
    class="active"
@stop

@section('main')

    <h1> All descriptors types </h1>

    <p> {{ link_to_route('descriptorsTypes.create', 'Add new descriptor type') }} </p>

    @if ($descriptorsTypes->count())
        <table class="table table-striped table-ordered">
            <thead>
                <tr>
                    <th>Descriptor Type Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($descriptorsTypes as $descriptorType)
                <tr>
                    <td> {{ $descriptorType->description }}  </td>

                    <td> {{ link_to_route('descriptorsTypes.edit', 'Edit', array($descriptorType->id), array('class'=>'btn btn-info')) }} </td>

                    <td>
                        {{ Form::open(array('method'=>'DELETE', 'route'=>array('descriptorsTypes.destroy', $descriptorType->id))) }}
                        {{ Form::submit('Delete', array('class'=>'btn btn-danger', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $descriptorsTypes->links() }}  {{-- code at the left is for breadcrumbes --}}
    @else
        There are no descriptors types
    @endif
    
@stop {{-- End of section main --}}