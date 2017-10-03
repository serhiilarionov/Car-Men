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
                    @include('$MODULE_NAME_SMALL$::articles.show_fields')
                    <a href="{!! route('$MODULE_NAME_SMALL$.articles.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
