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
  $.widget( "custom.catcomplete", $.ui.autocomplete, {
    _create: function() {
      this._super();
      this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
    },
    _renderMenu: function( ul, items ) {
      var that = this,
        currentCategory = "";
      $.each( items, function( index, item ) {
        var li;
        if ( item.category != currentCategory ) {
          ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
          currentCategory = item.category;
        }
        li = that._renderItemData( ul, item );
        if ( item.category ) {
          li.attr( "aria-label", item.category + " : " + item.label );
        }
      });
    }
  });
  </script>
  <script>
  $(function() {
    var scntDiv = $('#descriptors');
    $( "#description" ).catcomplete({
      delay: 0,
      source: '{{ url('jdescriptors') }}',
      select: function (event, ui) {
    $("#txDestination").val(ui.item.descriptor_id);
        $('<p> <input type="hidden" name="descriptor_id[]" value='+ ui.item.descriptor_id +'></p>').appendTo(scntDiv);
              }
          });
      });
  </script>
  
@stop

@section('main')

    <h1> Create product </h1>

    {{ Form::open(array('route'=>'products.store','class'=>'horizontal','role'=>'form')) }}

    <div class="form-group">
        {{ Form::text('description', '',array('id'=>'description', 'class'=>'ui-widget')) }}
        
        <div id="descriptors">
             
        </div>
        
        <a href="#" id="addDescriptor">Add another descriptor</a>
        
        <dt>
        {{ Form::submit('submit', array('class'=>'btn btn-info')) }}
        {{ link_to_route('products.index', 'Cancel', [],array('class'=>'btn btn-info')) }}
        </dt>
    </div>

    {{ Form::close() }}
    
    

    @if ($errors->any())
    <ul>
        {{ implode('',$errors->all('<li class="error">:message</li>')) }}
    </ul>
    @endif

@stop
