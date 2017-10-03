<!-- Company Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('company_id', 'Company Id:') !!}
    {!! Form::number('company_id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Display Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('display_name', 'Display Name:') !!}
    {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Text Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('text', 'Text:') !!}
    {!! Form::textarea('text', null, ['class' => 'form-control']) !!}
</div>

<!-- Total Rating Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_rating', 'Total Rating:') !!}
    {!! Form::number('total_rating', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Rel Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price_rel', 'Price Rel:') !!}
    {!! Form::number('price_rel', null, ['class' => 'form-control']) !!}
</div>

<!-- Answer Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('answer_name', 'Answer Name:') !!}
    {!! Form::text('answer_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Answer Text Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('answer_text', 'Answer Text:') !!}
    {!! Form::textarea('answer_text', null, ['class' => 'form-control']) !!}
</div>

<!-- Answer Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('answer_date', 'Answer Date:') !!}
    {!! Form::date('answer_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('catalog.companyRatings.index') !!}" class="btn btn-default">Cancel</a>
</div>
