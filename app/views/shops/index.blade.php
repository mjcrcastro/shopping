@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
    active
@stop

@section('main')

<div class="container container-fluid">
    <div class="row col-xs-12">
        <h1> All shops </h1>

        <p> {{ link_to_route('shops.create', 'Add new shop') }} </p>
    </div>
    <div class="row col-xs-12">
    @if ($shops->count())
        <table class="table table-striped table-ordered">
            <thead>
                <tr>
                    <th>Shop Name</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shops as $shop)
                <tr>
                    <td> {{ $shop->description }}  </td>
                    
                    <td>
                        <a href="http://maps.google.com/?q={{ $shop->description }} {{ $shop->locationAddress }}" target='_blank'>
                                    <span class='glyphicon glyphicon-search' aria-hidden='true'></span><a>
                    </td>

                    <td> {{ link_to_route('shops.edit', 'Edit', array($shop->id), array('class'=>'btn form-control btn-info')) }} </td>

                    <td>
                        {{ Form::open(array('method'=>'DELETE', 'route'=>array('shops.destroy', $shop->id))) }}
                        {{ Form::submit('Delete', array('class'=>'btn btn-danger form-control', 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
        {{ $shops->links() }}  {{-- code at the left is for breadcrumbes --}}
    @else
        There are no shops
    @endif
    
@stop {{-- End of section main --}}