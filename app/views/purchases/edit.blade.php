@extends('master')

@section('products_active')
active
@stop

@section('main')

<h1> Create purchase </h1>


<div class="container">
    <div class="container container-fluid">
        <div class="row">
            <div class="col-xs-12">
                    {{ Form::model(array('route'=>'purchases.update','class'=>'horizontal','role'=>'form')) }}
                    {{ Form::label('shop', 'Shop:') }}
                    {{ Form::select('shop_id', $shops, null, array('class'=>'form-control')) }}
                    
                    {{ Form::label('date', 'Date:') }}
                    {{ Form::text('purchase_date', date('Y-m-d'), array('class'=>'form-control', 'id'=>'purchase_date')) }}
                    
                    {{ Form::label('is_reference', '(This is only for price reference ') }}
                    {{ Form::checkbox('is_reference',null,array('class'=>'form-control')) }})
                <p></p>
                {{ Form::submit('Submit', array('class'=>'btn  btn-primary col-xs-6')) }}
                {{ link_to_route('purchases.index', 'Cancel', [],array('class'=>'btn btn-default col-xs-6')) }}
                {{ Form::close() }}


            </div>

            <p></p>

            </dt>
        </div>
    </div>
</div>

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop
