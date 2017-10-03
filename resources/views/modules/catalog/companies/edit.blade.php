@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Company
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($company, ['route' => ['catalog.companies.update', $company->id], 'method' => 'patch']) !!}

                        @include('catalog::companies.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection