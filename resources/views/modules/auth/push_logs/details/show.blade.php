@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Push Log
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('auth::push_logs.details.show_fields')
                    <a href="{!! route('auth.pushLogDetails.index', ['pushLogDay' => session()->get('pushLogDay')]) !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
