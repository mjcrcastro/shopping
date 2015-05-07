@extends('master')

@section('dashboard_active')
class="active"
@stop

@section('header')

{{ HTML::script('//code.highcharts.com/highcharts.js') }}
{{ HTML::script('//code.highcharts.com/highcharts-more.js') }}
{{ HTML::script('//code.highcharts.com/modules/exporting.js') }}

<script type="text/javascript">

    var options = {
            chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
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
                data: []
            }]
    };

    $(function () {
        $('#container').highcharts(options);
    });
</script>


@stop

@section('main')

<h1> Dashboard </h1>

<div id="container" class="col-sx-12"></div>

@stop 
