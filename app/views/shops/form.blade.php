    <div class="form-group">
        {{ Form::label('description', 'Shop Description:') }}
        {{ Form::text('description',null,array('class="form-control"')) }}
        {{ Form::label('locationAddress', 'Address:') }}
        {{ Form::text('locationAddress',null,array('class="form-control"')) }}
        {{ Form::submit('Submit', array('class'=>'btn  btn-primary col-xs-6')) }}
        {{ link_to_route('shops.index', 'Cancel', [],array('class'=>'btn btn-default col-xs-6')) }}
    </div>