@extends('master')

@section('shopping_lists_active')
active
@stop

@section('header')

<script type='text/javascript'>
    /*
     * Script to delete a product in the shopping list
     */
    $(window).load(function () {
        $(document).on('click', '#removedescriptor', function () {
            $(this).parents('#productRow').remove();
            return false;
        });
    });
    
</script>

<script type='text/javascript'>
    /*
     * Displays list of products using
     * a datatables jQuery plugin on table id="example"
     */
    $(document).ready(function () {
        var table = $('#productslist').dataTable({
            "processing": true,
            "serverSide": true,
            "iDisplayLength": 5,
            "aLengthMenu": [
                [5, 10, 25, 50, -1], 
                [5, 10, 25, 50, "All"]],
            dom: '<"row"<"col-xs-4"l><"col-xs-8"f>>rt<"text-center"T>ip',
            tableTools: {
                "sRowSelect": "multi",
                "aButtons": [
                    {"sExtends": "text", 
                        "sButtonText": "add to shopping list",
                        "sButtonClass": "btn-block",
                        "fnClick": function (nButton, oConfig, oFlash) {
                            var oTT = TableTools.fnGetInstance('productslist');
                            var aData = oTT.fnGetSelectedData()
                            
                            for (nCount = 0; nCount < aData.length; nCount++) {
                                $('#myModal').modal('hide');
                                //check if there exists a product with same id in purchase list
                                //$.inArray only compares between numbers or characters
                                //so I converted the values to Int within the array before comparison.
                                
                                var values = $("input[id='productarray']")//gets the value of all elements whose id is productarray
                                    .map(function () {
                                        return parseInt($(this).val());
                                    }).get();
                                
                                if (!values.length || $.inArray(aData[nCount]['product_id'], values) === -1) {
                                    $('<div class="container container-fluid">' +
                                            '<div class="row" id="productRow">' +
                                            '<input type="hidden" id="productarray" name="product_id[]" value=' + aData[nCount]['product_id'] + '>' +
                                            '<div class="col-xs-4"> ' + aData[nCount]['product_description'] + ' </div> ' +
                                            '<div class="col-xs-3"> {{ Form::number("amount[]",1,array("class"=>"form-control input-sm","step"=>"any","id"=>"amount")) }} </div>' +
                                            '<input type="hidden" id="unitPrice" name="unitprice[]" value=' + aData[nCount]['price'] + '>' +
                                            '<div class="col-xs-3"> <input type="number" id="total" class="form-control input-sm" name="total[]" value=' + aData[nCount]['price'] + ' step="0.01" disabled> </div>' +
                                            '<div class="col-xs-2"> <a href="#" id="removedescriptor">' +
                                            '{{ HTML::image("img/delete.png", "remove", array( "width" => 16, "height" => 16 )) }} ' +
                                            '</a></div> ' +
                                            '</div></div>').appendTo('#products');
                                }
                            }
                        }
                    }
                ]
            },
            "ajax": {
                "url": "{{ url('jshoppinglist') }}",
                "type": "GET"
            },
            "aoColumnDefs": [
                {
                    "aTargets": [0],
                    "bVisible": false,
                    "bSearchable": false
                }
            ],
            "columns": [//tells where (from data) the columns are to be placed
                {"data": "product_id"},
                {"data": "product_description"},
                {"data": "shops_description"},
                {"data": "price"},
                {"data": "purchase_date"}

            ]
        });
        
        $('#productslist')
        .removeClass('display')
        .addClass('table table-striped table-bordered');
    });
    
    

    $(document).on('click', '#addProducts', function () {
        //Show modal bootstrap
        $('#myModal').modal('show');
        //return
    });
    
    $(document).on('input','#amount',function(){
        //navigate to the parent to find the total since
        //total is not a sibling, but it is part of 
        //#productRow family down the tree
        total = $(this).parents('#productRow').find('#total');
        unitPrice = $(this).parents('#productRow').find('#unitPrice');
        total.val($(this).val()*unitPrice.val());
        
    });
    
</script>

@stop

@section('main')

<h1> Create shopping list </h1>


<div class="container">
    <div class="container container-fluid">
        <div class="row">
            <div class="col-xs-12">
                    {{ Form::open(array('route'=>'shoppingLists.store','class'=>'horizontal','role'=>'form')) }}
                <div class="row">
                    <dt>
                    <div class="col-xs-4">
                        Product
                    </div>
                    <div class="col-xs-3">
                        Qt
                    </div>
                    <div class="col-xs-3">
                        Cost
                    </div>
                    <div class="col-xs-2">
                    </div>
                </div>

                <div class="row" id="products">
                </div>
                <p></p>
                {{ HTML::link('#', 'Add Items',array('class'=>'btn btn-success btn-block col-xs-12','id'=>'addProducts')) }}
                <p></p>
                {{ Form::submit('Submit', array('class'=>'btn  btn-primary col-xs-6')) }}
                {{ link_to_route('shoppingLists.index', 'Cancel', [],array('class'=>'btn btn-default col-xs-6')) }}
                {{ Form::close() }}


            </div>

            <p></p>

            </dt>
        </div>
    </div>
</div>


{{-- bootstrap modal --}}

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Search products</h4>
            </div>
            <div class="modal-body">
                <table id="productslist" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Product</th>
                            <th>Shop</th>
                            <th>Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Product</th>
                            <th>Shop</th>
                            <th>Price</th>
                            <th>Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- bootstrap modal --}}
@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop
