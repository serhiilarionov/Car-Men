<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $pushLog->id !!}</p>
</div>

<!-- Push Name Field -->
<div class="form-group">
    {!! Form::label('push_name', 'Push Name:') !!}
    <p>{!! $pushLog->push_name !!}</p>
</div>

<!-- Message Id Field -->
<div class="form-group">
    {!! Form::label('message_id', 'Message Id:') !!}
    <p>{!! $pushLog->message_id !!}</p>
</div>

<!-- Device Id Field -->
<div class="form-group">
    {!! Form::label('device_id', 'Device Id:') !!}
    <p>{!! $pushLog->device_id !!}</p>
</div>

<!-- Send Status Field -->
<div class="form-group">
    {!! Form::label('send_status', 'Send Status:') !!}
    <p>{!! $pushLog->send_status !!}</p>
</div>

<!-- Read Status Field -->
<div class="form-group">
    {!! Form::label('read_status', 'Read Status:') !!}
    <p>{!! $pushLog->read_status !!}</p>
</div>

