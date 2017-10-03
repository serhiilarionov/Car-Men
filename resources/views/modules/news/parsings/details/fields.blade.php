<!-- Source Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Source:') !!}
    @if(isset($article))
        {!! Form::select('source_id', $sources->pluck('name', 'id'), $article->source_id,
        ['placeholder' => 'No source', 'class' => 'form-control']) !!}
    @else
        {!! Form::select('source_id', $sources->pluck('name', 'id'), null,
        ['placeholder' => 'No source', 'class' => 'form-control']) !!}
    @endif
</div>

<!-- title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- text Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Text:') !!}
    {!! Form::text('text', null, ['class' => 'form-control']) !!}
</div>

<!-- source_link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Source link:') !!}
    {!! Form::text('source_link', null, ['class' => 'form-control']) !!}
</div>

<!-- image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Image:') !!}
    {!! Form::text('image', null, ['class' => 'form-control']) !!}
</div>

<!-- publication_date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Publication date:') !!}
    @if(isset($article))
        {!! Form::input('date', 'publication_date',
        \Carbon\Carbon::parse($article->publication_date)->format('Y-m-d'), ['class' => 'form-control']) !!}
    @else
        {!! Form::input('date', 'publication_date', null, ['class' => 'form-control']) !!}
    @endif
</div>

<!-- verified Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Verified:') !!}
    {!! Form::checkbox("verified", null, 1) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('news.parsingDetails.index', ['day' => session()->get('day')]) !!}" class="btn btn-default">Cancel</a>
</div>
