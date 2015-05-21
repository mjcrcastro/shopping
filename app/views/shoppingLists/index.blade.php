@extends('master')

@section('purchases_active')
active
@stop

@section('form_search')
{{-- Creates a form search on the menu bar --}}
{{ Form::open(array('class'=>'navbar-form navbar-left','method'=>'get','role'=>'search','route'=>'purchases.index')) }}
<div class="form-group">
    {{ Form::text('filter',$filter,array('class'=>'form-control','placeholder'=>'Search')) }}
</div>
{{ Form::submit('Search', array('class'=>'btn btn-default')) }} 
{{ Form::close() }}

@stop

@section('main')

<p> {{ link_to_route('purchases.create', Lang::get('purchases.add.new')) }} </p>

@if ($purchases->count())
<table class="table table-striped table-ordered table-condensed">
    <thead>
        <tr>
            <th>{{Lang::get('purchases.store')}}</th>
            <th>Date</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchases as $purchase)
        <tr>

            <td> 
                {{ $purchase->shop->description }}
            </td>

            <td>
                {{ $purchase->purchase_date }}
            </td>

            <td> 
                {{ link_to_route('purchases.edit', 'Edit', array($purchase->id), array('class'=>'btn btn-info '.Config::get('global/default.button_size'))) }} 
            </td>

            <td>
                {{ Form::open(array('method'=>'DELETE', 'route'=>array('purchases.destroy', $purchase->id))) }}
                {{ Form::submit('Delete', array('class'=>'btn btn-danger '.Config::get('global/default.button_size'), 'onclick'=>"if(!confirm('Are you sure to delete this item?')){return false;};")) }} 
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $purchases->appends(array('filter'=>$filter))->links() }}
@else
There are no purchases
@endif
@stop