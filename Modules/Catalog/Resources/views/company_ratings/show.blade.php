@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Company Rating
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('catalog::company_ratings.show_fields')
                    <a class="btn btn-default" onclick="setTimeout('window.history.back()',0);">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
