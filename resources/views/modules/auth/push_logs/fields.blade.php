<!-- Push Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('push_name', 'Push Name:') !!}
    {!! Form::text('push_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Send count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Send count:') !!}
    {!! Form::text('send_count', null, ['class' => 'form-control']) !!}
</div>

<!-- Read count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Read count:') !!}
    {!! Form::text('read_count', null, ['class' => 'form-control']) !!}
</div>

<!-- Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Day:') !!}
    {!! Form::text('pushLogDay', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('auth.pushLogs.index') !!}" class="btn btn-default">Cancel</a>
</div>
