@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Comfort
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($comfort, ['route' => ['catalog.comforts.update', $comfort->id], 'method' => 'patch']) !!}

                        @include('catalog::comforts.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection