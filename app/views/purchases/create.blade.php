@extends('master')

@section('products_active')
active
@stop

@section('header')

<script type='text/javascript'>
    /*
     * 
     */
    $(window).load(function () {
        $(function () {
            $(document).on('click', '#addDescriptor', function () {
                $('<div id="productrow">    {{ Form::hidden("products[]") }} ' +
                        '<div class="col-xs-7"> {{ "product description" }} </div> ' +
                        '<div class="col-xs-2"> {{ Form::text("amounts[]",null,array("class"=>"form-control input-sm")) }} </div> ' +
                        '<div class="col-xs-2"> {{ Form::text("totals[]",null,array("class"=>"form-control input-sm")) }} </div> ' +
                        '<div class="col-xs-1"> <a href="#" id="removedescriptor">' +
                        '{{ HTML::image("img/delete.png", "remove", array( "width" => 16, "height" => 16 )) }} ' +
                        '</a></div> ' +
                        '</div>').appendTo('#products');
                return false;
            });
            $(document).on('click', '#removedescriptor', function () {
                    $(this).parents('#productrow').remove();
                return false;
            });
        });
    });</script>

<script type='text/javascript'>
    /*Shows a datepicker widget for
     * the purchase_date text input control
     */
    $(function () {
        $("#purchase_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
    });</script>

<script type='text/javascript'>
    /*
     * Displays list of products using
     * a datatables jQuery plugin on table id="example"
     */
    $(document).ready(function () {
        var table = $('#example').dataTable({
            "processing": true,
            "serverSide": true,
            dom: 'T<"clear">lfrtip',
            tableTools: {
                    "sRowSelect": "multi",
                    "aButtons": [
                        {"sExtends": "text", "sButtonText": "add selection to purchase",
                            "fnClick": function (nButton, oConfig, oFlash) {
                                $('<div id="productrow">    {{ Form::hidden("products[]") }} ' +
                                        '<div class="col-xs-7"> {{ "product description" }} </div> ' +
                                        '<div class="col-xs-2"> {{ Form::text("amounts[]",null,array("class"=>"form-control input-sm")) }} </div> ' +
                                        '<div class="col-xs-2"> {{ Form::text("totals[]",null,array("class"=>"form-control input-sm")) }} </div> ' +
                                        '<div class="col-xs-1"> <a href="#" id="removedescriptor">' +
                                        '{{ HTML::image("img/delete.png", "remove", array( "width" => 16, "height" => 16 )) }} ' +
                                        '</a></div> ' +
                                        '</div>').appendTo('#products');
                                return false;
                            }
                        }
                    ]
                },
                "ajax": {
                    "url": "{{ url('jproducts') }}",
                    "type": "GET"
                },
                "columns": [//tells where (from data) the columns are to be placed
                    {"data": "product_description"}
                ]
            });


            $('#example tbody').on('click', 'tr', function () {
                $(this).toggleClass('selected');
            });

        });
</script>

@stop

@section('main')

<h1> Create purchase </h1>

{{ Form::open(array('route'=>'purchases.store','class'=>'horizontal','role'=>'form')) }}
<div class="container">

    <div class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <dt>
                    {{ Form::label('shop', 'Shop:') }}
                    {{ Form::select('shop_id', $shops, null, array('class'=>'form-control')) }}
                    </dd>

                    <dt>
                    {{ Form::label('date', 'Date:') }}
                    {{ Form::text('purchase_date', date('Y-m-d'), array('class'=>'form-control', 'id'=>'purchase_date')) }}
                    </dd>

                    <dt>
                    <p></p>
                    <div class="row">
                        <div class="col-xs-4">
                            Product
                        </div>
                        <div class="col-xs-4">
                            Amount
                        </div>
                        <div class="col-xs-4">
                            Total Cost
                        </div>
                        <div class='row'>
                            <div class='col-xs-12'>
                                <hr>
                            </div>
                        </div>
                        <div clas="row">
                            <div id="products"></div>
                        </div>
                    </div>

                    <a href="#" id="addDescriptor">Add another descriptor</a>
                    </dt>

                    <dt>
                    {{ Form::submit('submit', array('class'=>'btn btn-info')) }}
                    {{ link_to_route('purchases.index', 'Cancel', [],array('class'=>'btn btn-info')) }}
                    </dt>

                </div>

                <div class="col-xs-6">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Product</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Product</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop
