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
    var scntDiv = $('#descriptors'); //id of the div in which the 
                                     //descriptors will be inserted
    $( "#description" ).catcomplete({
      delay: 0,
      source: '{{ url('jdescriptors') }}', //read entries from a service url
      select: function (event, ui) { //function to run on select event
    $("#txDestination").val(ui.item.descriptor_id);
    //add a hidden input with the descriptor's id along with 
    //a href with the description, and an image link 
    //to be able to remove the descriptor later
        $('<p> <input type="hidden" name="descriptor_id[]" value=' + 
                ui.item.descriptor_id + '>' + 
                ui.item.label + 
                '<a href="#" id="removedescriptor">' +
                '{{ HTML::image('img/delete.png', 'remove', array( 'width' => 16, 'height' => 16 )) }}' +
                '</a></p>').appendTo(scntDiv);
        $(this).val(''); //clear text from the textbox
        return false; //returns false to cancel the event
              }
          });
          $(document).on('click', '#removedescriptor', function () { //removes the <p></p> block 
              $(this).parents('p').remove();
          });
      });

  </script>
  
@stop

@section('main')

    <h1> Create product </h1>

    {{ Form::open(array('route'=>'products.store','class'=>'horizontal','role'=>'form')) }}

    <div class="form-group">
        
        <div id="descriptors">
            {{-- Placeholder for list of added descriptors --}} 
        </div>
        
        <p>
        
        {{ Form::text('description', '',array('id'=>'description', 'class'=>'ui-widget')) }}
        
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
