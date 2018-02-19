@extends('adminlte::page')

@section('title', $site_title)

@section('content_header')
    <h1>{{ $page_title }}</h1>
@stop

@section('content')

    {{ dump($role_item) }}

@stop