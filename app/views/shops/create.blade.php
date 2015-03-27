@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
@section('config_active')
active
@stop

@section('header')
<script>$(function ()
    {
        var map = L.map('wLocationMap').setView([51.505, -0.09], 13);
        // add an OpenStreetMap tile layer
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function onMapClick(e) {
            document.getElementById("locationMap").value = e.latlng;
        }

        map.on('click', onMapClick);

        $('.open-popup-link').magnificPopup({
            type: 'inline',
            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        });

    });



</script>
@stop

@section('main')



<h1> Create Shop </h1>

{{ Form::open(array('route'=>'shops.store')) }}

<ul>
    <li>
        {{ Form::label('description', 'Shop Description:') }}
        {{ Form::text('description') }}
    </li>
    <li>
        {{ Form::hidden('locationMap',null,array('id'=>'locationMap')) }}

        <div id="wLocationMap" class="white-popup mfp-hide" style="width: 500px; height: 400px;"></div>
        
        <a href="#wLocationMap" class="open-popup-link">Show inline popup</a>

    </li>
    <li>
        {{ Form::submit('submit', array('class'=>'btn')) }}
    </li>

</ul>
{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop