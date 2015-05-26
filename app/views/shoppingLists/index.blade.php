@extends('master')

@section('shopping_lists_active')
active
@stop

@section('form_search')
{{-- Creates a form search on the menu bar --}}
{{ Form::open(array('class'=>'navbar-form navbar-left','method'=>'get','role'=>'search','route'=>'shoppingLists.index')) }}
<div class="form-group">
    {{ Form::text('filter',$filter,array('class'=>'form-control','placeholder'=>'Search')) }}
</div>
{{ Form::submit('Search', array('class'=>'btn btn-default')) }} 
{{ Form::close() }}

@stop

@section('main')

<p> {{ link_to_route('shoppingLists.create', Lang::get('shoppingLists.add.new')) }} </p>

@if ($shoppingLists->count())
<table class="table table-striped table-ordered table-condensed">
    <thead>
        <tr>
            <th>{{Lang::get('shoppingLists.store')}}</th>
            <th>Date</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shoppingLists as $shoppingList)
        <tr>

            <td> 
                {{ $shoppingList->shop->description }}
            </td>

            <td>
                {{ $shoppingList->planned_date }}
            </td>

            <td> 
                {{ link_to_route('shoppingLists.edit', 'Edit', array($shoppingList->id), array('class'=>'btn btn-info '.Config::get('global/default.button_size'))) }} 
            </td>

            <td>
                {{ Form::open(array('method'=>'DELETE', 'route'=>array('purchases.destroy', $shoppingList->id))) }}
                {{ Form::submit('Delete', array('class'=>'btn btn-danger '.Config::get('global/default.button_size'), 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }} 
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $shoppingList->appends(array('filter'=>$filter))->links() }}
@else
There are no purchases
@endif
@stop