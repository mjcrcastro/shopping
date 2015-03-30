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
        var map = L.map('wLocationMap', {
            closeButton: false
        });
        $('wLocationMap').addClass('mfp-hide');
        // add an OpenStreetMap tile layer
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        var osmGeocoder = new L.Control.OSMGeocoder();

	map.addControl(osmGeocoder);

        var marker;
        
        map.on('click', onMapClick);

        function onMapClick(e) {

            if (confirm("Set new location here?") === false) {
                return;
            }

            if (marker) {
                map.removeLayer(marker);
            }
            marker = new L.Marker(e.latlng, {draggable: true});
            map.addLayer(marker);
            marker.bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();
            document.getElementById("locationLat").value = marker.getLatLng().lat;
            document.getElementById("locationLng").value = marker.getLatLng().lng;
        }
        
        $('.open-popup-link').magnificPopup({
            type: 'inline',
            midClick: true, // allow opening popup on middle mouse click. 
            // Always set it to true if you don't provide 
            // alternative source.
            closeBtnInside: false,
            callbacks: {
                open: function () {
                    // Will fire when this exact popup is opened
                    // this - is Magnific Popup object
                    map.locate( {setView: true});
                    map.invalidateSize(true);
                }
            }
        });

    });



</script>
@stop

@section('main')

<div id="wLocationMap" class="white-popup  mfp-hide"></div>

<h1> Create Shop </h1>

{{ Form::open(array('route'=>'shops.store')) }}

<ul>
    <li>
        {{ Form::label('description', 'Shop Description:') }}
        {{ Form::text('description') }}
    </li>
    <li>
        {{ Form::hidden('locationLat',null,array('id'=>'locationLat')) }}
        {{ Form::hidden('locationLng',null,array('id'=>'locationLng')) }}

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