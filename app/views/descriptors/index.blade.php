@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
    active
@stop

{{-- this section is to show a form search for descriptors on the master blade--}}
@section('form_search')

{{ Form::open(array('class'=>'navbar-form navbar-left','method'=>'get','role'=>'search','route'=>'descriptors.index')) }}
    <div class="form-group">
        {{ Form::text('filter',$filter,array('class'=>'form-control','placeholder'=>'Search')) }}
        {{ Form::hidden('descriptorType_id', $descriptorType_id) }}
    </div>
{{ Form::submit('Search', array('class'=>'btn btn-default')) }} 
{{ Form::close() }}

@stop

@section('main')

    <h1> All descriptors {{ $label }} </h1>
    
    <p> {{ link_to_route('descriptors.create', 'Add new descriptor',array('descriptorType_id'=>$descriptorType_id)) }} </p>
    
    <p> {{ link_to_route('descriptors.csv', 'Download CSV') }} </p>
   
    

    @if ($descriptors->count())
        <table class="table table-striped table-ordered">
            <thead>
                <tr>
                    <th>Descriptor Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($descriptors as $descriptor)
                <tr>
                    <td> {{ $descriptor->description }}  </td>

                    <td> {{ link_to_route('descriptors.edit', 'Edit', array($descriptor->id), array('class'=>'btn btn-info')) }} </td>

                    <td>
                        {{ Form::open(array('method'=>'DELETE', 'route'=>array('descriptors.destroy', $descriptor->id))) }}
                        {{ Form::submit('Delete', array('class'=>'btn btn-danger', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $descriptors->links() }}  {{-- code at the left is for breadcrumbes --}}
    @else
        There are no descriptors
    @endif
    
@stop {{-- End of section main --}}