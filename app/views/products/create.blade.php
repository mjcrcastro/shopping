@extends('master')

@section('products_active')
    class = "active"
@stop

@section('header')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">

    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#inventor_review_date").datepicker();
        });
    </script>

@stop

@section('main')

    <h1> Create product </h1>

    {{ Form::open(array('route'=>'products.store','class'=>'horizontal','role'=>'form')) }}

    <div class="form-group">

            <dt>
            {{ Form::label('description', 'Long description:') }}
            </dt>
            <dd>
                {{ Form::text('description') }}
            </dd>
            <dt>
            {{ Form::label('short_description', 'Short description:') }}
            </dt>
            
            <dd>
                {{ Form::text('short_description') }}
            </dd>
            
             <dt>
            {{ Form::label('product_code', 'Product code:') }}
            </dt>
            
            <dd>
                {{ Form::text('product_code') }}
            </dd>
            
            
            <dt>
            {{ Form::submit('submit', array('class'=>'btn')) }}
            </dt>
    </div>

    {{ Form::close() }}

    @if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
    @endif

@stop
