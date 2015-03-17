@extends('master')

@section('products_active')
    active
@stop

@section('header')

    <script type='text/javascript'> 
      
    $(window).load(function(){
    $(function() {
            var scntDiv = $('#descriptors');
            var i = $('#p_scents p').size() + 1;

            $(document).on('click', '#addDescriptor',function() {
                    $('<p> {{ Form::select('descriptors[]', $descriptors) }} <a href="#" id="removedescriptor">Remove</a></p>').appendTo(scntDiv);
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

          });
    
    </script>

@stop

@section('main')

    <h1> Create product </h1>

    {{ Form::open(array('route'=>'products.store','class'=>'horizontal','role'=>'form')) }}

    <div class="form-group">

        <div id="descriptors">
            <p>
                
                {{ Form::select('descriptors[]', $descriptors) }}
                
            </p>
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
