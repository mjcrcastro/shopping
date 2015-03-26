@extends('master')

@section('products_active')
active
@stop

@section('header')

<script type='text/javascript'>
    /*
     * 
     */ * /
    $(window).load(function () {
            $(function () {
            var scntDiv = $('#products');
                    var i = $('#p_scents p').size() + 1;
                    $(document).on('click', '#addDescriptor', function () {
            $('<p>  {{ Form::hidden('products[]') }} ' +
                    '{{ 'product description' }}' +
                    '{{ Form::text('amounts[]') }} ' +
                    '{{ Form::text('totals[]') }} ' +
                    '<a href="#" id="removedescriptor">Remove</a></p>').appendTo(scntDiv);
                    i++;
                    return false;
            });
                    $(document).on('click', '#removedescriptor', function () {
            if (i > 1) {
            $(this).parents('p').remove();
                    i--;
            }
            return false;
            });
            });
    });</script>

<script>
            $(function() {
            $("#purchase_date").datepicker({
            changeMonth: true,
                    changeYear: true,
                    dateFormat: "yy-mm-dd"
            });
            });</script>

<script type='text/javascript'>
            $(document).ready(function () {
    $('#example').dataTable({
    "processing": true,
            "serverSide": true,
            "ajax": {
            "url": "{{ url('jproducts') }}",
                    "type": "GET"
            },
            "columns": [//tells where (from data) the columns are to be placed
            {"data": "product_description"},
            ]
    });
    });
</script>

@stop

@section('main')

<h1> Create purchase </h1>

{{ Form::open(array('route'=>'products.store','class'=>'horizontal','role'=>'form')) }}
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
                            <div class='span12'>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <a href="#" id="addDescriptor">Add another descriptor</a>
                    </dt>

                    <dt>
                    {{ Form::submit('submit', array('class'=>'btn btn-info')) }}
                    {{ link_to_route('products.index', 'Cancel', [],array('class'=>'btn btn-info')) }}
                    </dt>

                </div>

                <div class="col-sm-6">
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
