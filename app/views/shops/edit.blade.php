@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
    active
@stop

@section('main')

<h1> Edit Shop </h1>


{{ Form::model($shop, array('method'=>'PATCH', 'route'=> array('shops.update', $shop->id)))  }}
    @include('shops.form')
{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop