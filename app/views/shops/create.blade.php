@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
active
@stop

@section('main')

<div class='container container-fluid'>
    <h1> Create Shop </h1>
    {{ Form::open(array('route'=>'shops.store')) }}
    @include('shops.form')
    {{ Form::close() }}
</div>


@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop