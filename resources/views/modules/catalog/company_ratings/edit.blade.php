@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Company Rating
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($companyRating, ['route' => ['catalog.companyRatings.update', $companyRating->id], 'method' => 'patch']) !!}

                        @include('catalog::company_ratings.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection