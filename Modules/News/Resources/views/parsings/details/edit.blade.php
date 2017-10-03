@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Articles
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($article, ['route' => ['news.parsingDetails.update', $article->id], 'method' => 'patch']) !!}

                        @include('news::parsings.details.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection