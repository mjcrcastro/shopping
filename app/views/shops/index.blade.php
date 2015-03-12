@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('shops_active')
    class="active"
@stop

@section('main')

    <h1> All shops </h1>

    <p> {{ link_to_route('shops.create', 'Add new shop') }} </p>

    @if ($shops->count())
        <table class="table table-striped table-ordered">
            <thead>
                <tr>
                    <th>Shop Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shops as $shop)
                <tr>
                    <td> {{ $shop->description }}  </td>

                    <td> {{ link_to_route('shops.edit', 'Edit', array($shop->id), array('class'=>'btn btn-info')) }} </td>

                    <td>
                        {{ Form::open(array('method'=>'DELETE', 'route'=>array('shops.destroy', $shop->id))) }}
                        {{ Form::submit('Delete', array('class'=>'btn btn-danger', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $shops->links() }}  {{-- code at the left is for breadcrumbes --}}
    @else
        There are no companies
    @endif
    
@stop {{-- End of section main --}}