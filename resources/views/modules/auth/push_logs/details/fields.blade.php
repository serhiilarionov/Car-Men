<!-- Push Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('push_name', 'Push Name:') !!}
    {!! Form::text('push_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Message Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('message_id', 'Message Id:') !!}
    {!! Form::text('message_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Device Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_id', 'Device Id:') !!}
    {!! Form::text('device_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Send Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('send_status', 'Send Status:') !!}
    {!! Form::text('send_status', null, ['class' => 'form-control']) !!}
</div>

<!-- Read Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('read_status', 'Read Status:') !!}
    {!! Form::text('read_status', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('auth.pushLogDetails.index', ['pushLogDay' => session()->get('pushLogDay')]) !!}" class="btn btn-default">Cancel</a>
</div>
