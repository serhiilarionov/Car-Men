<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $city->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $city->name !!}</p>
</div>

<!-- Point Field -->
<div class="form-group">
    {!! Form::label('point', 'Point:') !!}
    <p>{!! $city->point['lat'] . ', ' . $city->point['lng'] !!}</p>
</div>

<!-- Bound Field -->
<div class="form-group">
    {!! Form::label('bound', 'Bound:') !!}
    <p>{!! $city->bound !!}</p>
</div>

<!-- Active Field -->
<div class="form-group">
    {!! Form::label('active', 'Active:') !!}
    <p>{!! $city->active !!}</p>
</div>

