@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User: <strong>{!! $user->name !!}</strong>
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="row">
           {!! Form::model($user, ['route' => ['auth.users.update', $user->id], 'method' => 'patch']) !!}

                @include('auth::users.fields')

           {!! Form::close() !!}
       </div>
   </div>
@endsection