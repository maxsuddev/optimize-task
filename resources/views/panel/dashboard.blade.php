@extends('panel.layouts.app')
@section('title', 'Lead')
@section('page', 'Dashboard')
    @section('content')
@if(session('success'))
    <div id="autoCloseAlert" class="alert alert-success alert-dismissible">
        {{ session('success') }}
    </div>
@endif

    @endsection
