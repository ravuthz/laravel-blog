@extends('adminlte::page')

@section('title', $site_title)

@section('content_header')
    <h1>{{ $page_title }}</h1>
@stop

@section('content')

    @include('crud.alert')
    
    <div class="row">
        <div class="col-xs-12">
            @if (view()->exists($view_include_form))
                <div class="box">
                    <div class="box-header">
                        {!! BootForm::open(['model' => $crud_item, 'store' => $route_prefix . '.store', 'update' => $route_prefix . '.update']) !!}
                                @include($view_include_form)
                        {!! BootForm::close() !!}
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    <p>No views <strong>form.blade.php</strong> found in <strong>views.{{ $view_prefix }}</strong></p>
                </div>
            @endif
        </div>
    </div>
    
@stop