 <!-- source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Source:') !!}
    <p>{!! $source['name'] !!}</p>
</div>

<!-- title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Title:') !!}
    <p>{!! $article['title'] !!}</p>
</div>

<!-- text Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Text:') !!}
    <p>{!! $article['text'] !!}</p>
</div>

<!-- source_link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Source link:') !!}
    <p>{!! $article['source_link'] !!}</p>
</div>

<!-- image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Image:') !!}
    <p>{!! $article['image'] !!}</p>
</div>

<!-- publication_date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Publication date:') !!}
    <p>{!! $article['publication_date'] !!}</p>
</div>

<!-- verified Field -->
<div class="form-group">
    {!! Form::label('name', 'Verified:') !!}
    {!! Form::checkbox("verified", null, 1, ['disabled']) !!}
</div>