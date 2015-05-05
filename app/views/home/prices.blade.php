@extends('master')

@section('dashboard_active')
class="active"
@stop

@section('header')

{{ HTML::script('js/highcharts/js/highcharts.js') }}
{{ HTML::script('js/highcharts/js/highcharts-more.js') }}
{{ HTML::script('js/highcharts/js/modules/exporting.js') }}

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'My purchases'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Expenditures share',
            data: {{ json_encode($data) }}
        }]
                
    });
});
</script>


@stop

@section('main')

<h1> Dashboard </h1>

<div id="container" class="col-sx-12"></div>

@stop 
