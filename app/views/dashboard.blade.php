@extends('master')

@section('dashboard_active')
 class="active"
@stop


@section('header')

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        
        {{ HTML::script('js/highcharts/js/highcharts.js') }}
        {{ HTML::script('js/highcharts/js/highcharts-more.js') }}
        {{ HTML::script('js/highcharts/js/modules/exporting.js') }}
                
        <script type="text/javascript">
        $(function () {
                $('#container').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Docket Summary'
                    },
                    xAxis: {
                        categories: ['Unipixel', 'MassMutual', 'Energous', 'PCCA', 'Harvard']
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Inventions Status'
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold',
                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            }
                        }
                    },
                    legend: {
                        align: 'right',
                        x: -70,
                        verticalAlign: 'top',
                        y: 20,
                        floating: true,
                        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                        borderColor: '#CCC',
                        borderWidth: 1,
                        shadow: false
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>' + this.x + '</b><br/>' +
                                    this.series.name + ': ' + this.y + '<br/>' +
                                    'Total: ' + this.point.stackTotal;
                        }
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: true,
                                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                                style: {
                                    textShadow: '0 0 3px black, 0 0 3px black'
                                }
                            }
                        }
                    },
                    series: [{
                            name: 'Not Yet Extracted',
                            data: [5, 3, 4, 7, 2]
                        }, {
                            name: 'In Progress',
                            data: [2, 2, 3, 2, 1]
                        }, {
                            name: 'Delivered',
                            data: [3, 4, 4, 2, 5]
                        }]
                });
            });


        </script>


@stop

@section('main')

    <h1> Dashboard </h1>

    <div id="container" col-sx-12></div>

@stop 
