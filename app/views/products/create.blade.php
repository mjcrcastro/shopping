@extends('master')

@section('products_active')
active
@stop

@section('header')

<style>
    .ui-autocomplete-category {
        font-weight: bold;
        padding: .2em .4em;
        margin: .8em 0 .2em;
        line-height: 1.5;
    }
</style>

<script>
    //to show the autocomplete with categories
    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _create: function () {
            this._super();
            this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
        },
        _renderMenu: function (ul, items) {
            var that = this,
                    currentCategory = "";
            $.each(items, function (index, item) {
                var li;
                if (item.category !== currentCategory) {
                    ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                    currentCategory = item.category;
                }
                li = that._renderItemData(ul, item);
                if (item.category) {
                    li.attr("aria-label", item.category + " : " + item.label);
                }
            });
        }
    });
</script>

<script>

    $(function () {

        //descriptors will be inserted
        $("#description").catcomplete({
            delay: 200,
            source: function (request, response) { //declared so I can send more than one parameter
                $.ajax({
                    url: '{{ url('jdescriptors') }}',
                    dataType: "json",
                    data: {
                        term: request.term,
                        descriptorType_id: parseInt($('#descriptorType option:selected').val())
                    },
                    success: function (data) {
                        response(data);
                    }

                });
            },
            response: function (event, ui) {
                if (ui.content.length === 0) {
                    var newDescription = $('#description').val();
                    var descriptorType_id = parseInt($('#descriptorType option:selected').val());
                    if (confirm('Add ' + newDescription + ' as a descriptor?')) {
                        var descriptor = {
                            descriptorType_id: descriptorType_id,
                            description: newDescription
                        };
                        $.ajax({
                            type: "POST",
                            url: "{{ route('descriptors.store') }}",
                            data: descriptor,
                            dataType: 'json',
                            success: function (data) {
                                addDescriptorToList(data.id, data.descriptorType_id, data.description);
                            }
                        });
                    } else {
                        return false;
                    }
                }
            },
            select: function (event, ui) { //function to run on select event
                addDescriptorToList(ui.item.descriptor_id, parseInt($('#descriptorType option:selected').val()), ui.item.label);
                $(this).val(''); //clear text from the textbox
                return false; //returns false to cancel the event
            }
        });
        $(document).on('click', '#removedescriptor', function () { //removes the <p></p> block 
            $(this).parents('p').remove();
        });
        $('#formSubmit').submit(function (e) {
            //se traen todos los inputs del formulario
            var values = $("input[id='descriptorArray']")//gets the value of all elements whose id is productarray
                    .map(function () {
                        return parseInt($(this).val());
                    }).get();
            if (!values.length) {
                alert('At least the generic name needs to be provided');
                e.preventDefault(); // Cancel the submit
                return false; // 
            }
            //upto 
        });
    });

    function addDescriptorToList(id, descriptorType_id, description) {
        //adds a hidden input with the descriptor's id along with 
        //a hidden input with the descriptorType's id along as well as 
        //a href with the description, and an image link 
        //to be able to remove the descriptor later
        var valuesDescriptor = $("input[id='descriptorArray']")//gets the value of all elements whose id is productarray
                .map(function () {
                    return parseInt($(this).val());
                }).get();
        
        var valuesDescriptorType = $("input[id='descriptorTypeArray']")//gets the value of all elements whose id is productarray
                .map(function () {
                    return parseInt($(this).val());
                }).get();
                
        if($.inArray(descriptorType_id, valuesDescriptorType) !== -1)   {
            alert('There is already a descriptor of this type');
            return false;
        }   

        if (!valuesDescriptor.length || $.inArray(id, valuesDescriptor) === -1) {
            $('<p> ' +
                    '<input type="hidden" name="descriptor_id[]" id="descriptorArray" value=' + id + '>' +
                    '<input type="hidden" name="descriptorType_id[]" id="descriptorTypeArray" value=' + descriptorType_id + '>' +
                    $('#descriptorType option:selected').text() + ': ' + description + ' ' +
                    '<a href="#" id="removedescriptor">' +
                    '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>' +
                    '</a>' +
                    '</p>').appendTo('#descriptors');
        }
    }

</script>

@stop

@section('main')

<h1 class="h1" > Create product </h1>
<div class ="container-fluid">
    {{ Form::open(array('route'=>'products.store','class'=>'horizontal','role'=>'form','id'=>'formSubmit')) }}

    <div class="form-group">

        <div class="panel panel-default">
            <div class="panel-body">
                <div id="descriptors">
                    {{-- Placeholder for list of added descriptors --}} 
                </div>
            </div>
        </div>

        <p>
            {{ Form::label('DescriptorType', 'Descriptor Type:') }}
            {{ Form::select('descriptorType_id', $descriptorsTypes, null, array('class'=>"form-control",'id'=>'descriptorType')) }}
            {{ Form::text('description', '',array('id'=>'description', 'class'=>'ui-widget form-control')) }}
        <p>
            {{ Form::submit('submit', array('class'=>'btn btn-info','id'=>'submitButton')) }}
            {{ link_to_route('products.index', 'Cancel', [],array('class'=>'btn btn-primary')) }}

    </div>
</div>

{{ Form::close() }}



@if ($errors->any())
<ul>
    {{ implode('',$errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop
