@extends('master')

@section('dropdown_product')
   active
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

    <h1> Edit product </h1>


    {{ Form::model($product, array('method'=>'PATCH', 'route'=> array('products.update', $product->id)))  }}

    <dl class="dl-horizontal">
        <dt>
        {{ Form::label('description', 'Long Description:') }}
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
        {{ Form::submit('submit', array('class'=>'btn')) }}
        </dt>

    </dl>
    {{ Form::close() }}

    @if ($errors->any())
        <ul>
            {{ implode('',$errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif

@stop