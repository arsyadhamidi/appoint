@extends('admin.layout.master')
@section('title', 'Dashboard | Appoint')
@section('menuDashboard', 'active')

@section('content')
    @if (Auth()->user()->level_id == '1')
        @include('admin.index')
    @elseif(Auth()->user()->level_id == '2')
        @include('siswa.index')
    @elseif(Auth()->user()->level_id == '3')
        @include('guru.index')
    @elseif(Auth()->user()->level_id == '4')
        @include('waka.index')
    @elseif(Auth()->user()->level_id == '5')
        @include('kepala.index')
    @endif
@endsection
