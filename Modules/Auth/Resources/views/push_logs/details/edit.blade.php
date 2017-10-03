@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Push Log
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pushLog, ['route' => ['auth.pushLogDetails.update', $pushLog->id], 'method' => 'patch']) !!}

                        @include('auth::push_logs.details.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection