@extends('master')

@section('config_active')
active
@stop

@section('header')

@stop

@section('main')

<h1> Edit 
    
    @foreach ($product->productDescriptors as $productdescriptor)
        {{ $productdescriptor->descriptor->description.' '}}
    @endforeach

</h1>


{{ Form::model($product, array('method'=>'PATCH', 'route'=> array('products.update', $product->id)))  }}

<dl class="dl-horizontal">
    <dt>
    {{ Form::label('productType', 'Product Type:') }}
    </dt>
    <dd>
        {{ Form::select('productType_id', $productsTypes) }}
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