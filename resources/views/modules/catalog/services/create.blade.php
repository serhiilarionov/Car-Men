@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Service
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'catalog.services.store']) !!}

                        @include('catalog::services.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
