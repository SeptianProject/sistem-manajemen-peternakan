@extends('modules.dashboard.layouts.app')

@section('title', 'Dashboard Pemilik')
@section('heading', 'Selamat datang, '.auth()->user()->nama.'!')
@section('description', 'Pantau kondisi dan aktivitas peternakan Anda dari satu tempat.')

@section('content')
    @include('modules.dashboard.overview-content')
@endsection
