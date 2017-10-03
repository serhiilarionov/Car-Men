<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Bound Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bound', 'Bound:') !!}
    {!! Form::text('bound', null, ['class' => 'form-control']) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('point[lat]', 'Lat:') !!}
    {!! Form::text('point[lat]', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('point[lng]', 'Lng:') !!}
    {!! Form::text('point[lng]', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('catalog.cities.index') !!}" class="btn btn-default">Cancel</a>
</div>
