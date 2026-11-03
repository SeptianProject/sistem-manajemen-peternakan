@extends('modules.dashboard.layouts.app')

@section('title', 'Dashboard Petugas')
@section('heading', 'Selamat datang, '.auth()->user()->nama.'!')
@section('description', 'Pantau dan catat aktivitas operasional peternakan.')

@section('content')
    @include('modules.dashboard.overview-content')
@endsection
