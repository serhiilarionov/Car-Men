<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $device->id !!}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{!! $device->user_id !!}</p>
</div>

<!-- Device Id Field -->
<div class="form-group">
    {!! Form::label('device_id', 'Device Id:') !!}
    <p>{!! $device->device_id !!}</p>
</div>

<!-- Push Token Field -->
<div class="form-group">
    {!! Form::label('push_token', 'Push Token:') !!}
    <p>{!! $device->push_token !!}</p>
</div>

<!-- Device Type Field -->
<div class="form-group">
    {!! Form::label('device_type', 'Device Type:') !!}
    <p>{!! $device->device_type !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $device->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $device->updated_at !!}</p>
</div>

