@extends('modules.dashboard.layouts.app')

@section('title', 'Dashboard Superadmin')
@section('heading', 'Selamat datang, '.auth()->user()->nama.'!')
@section('description', 'Pantau aktivitas peternakan dan pengguna dari satu tempat.')

@section('content')
    @include('modules.dashboard.overview-content')
@endsection
