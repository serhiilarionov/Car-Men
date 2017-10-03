@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Articles
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('news::parsings.details.show_fields')
                    <a href="{!! route('news.parsingDetails.index', ['day' => session()->get('day')]) !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
