@extends('adminlte::page')

@section('title', $site_title)

@section('content_header')
    <div class="row">
        <div class="col-xs-12">
            <h3>
                {{ $page_title }}
                <a href="{{ route($route_prefix . '.create') }}" class="btn btn-sm btn-primary pull-right">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Create New
                </a>
            </h3>
        </div>
    </div>
@stop

@section('content')

    @include('crud.alert')
    
    @if(view()->exists($view_include_search))
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    {!! BootForm::open(['route' => $route_prefix . '.index', 'method' => 'get']) !!}
                        @include($view_include_search)
                    {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <div class="row">
        <div class="col-xs-12">
            @if(view()->exists($view_include_table))
                <div class="box">
                    <div class="box-header">
                        @include($view_include_table)
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    <p>No views <strong>table.blade.php</strong> found in <strong>views.{{ $view_prefix }}</strong></p>
                </div>
            @endif
        </div>
    </div>
    
@stop

@section('js')
    <script type="text/javascript">
        $(function(){
            $('.crud-table').on('click', '.btn-delete-row', function() {
                if (confirm("Do you really what to delete this record?")) {
                    $(this).next('.form-delete-row').submit();
                }
            });
        });
    </script>
@stop