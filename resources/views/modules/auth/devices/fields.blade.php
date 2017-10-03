<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Device Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_id', 'Device Id:') !!}
    {!! Form::text('device_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Push Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('push_token', 'Push Token:') !!}
    {!! Form::text('push_token', null, ['class' => 'form-control']) !!}
</div>

<!-- Device Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_type', 'Device Type:') !!}
    {!! Form::text('device_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('device.devices.index') !!}" class="btn btn-default">Cancel</a>
</div>
