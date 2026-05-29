@extends('layouts.app')

@section('content')
    @if(auth()->user()->isAdmin())
        @include('dashboards.admin')
    @elseif(auth()->user()->isDosen())
        @include('dashboards.dosen')
    @elseif(auth()->user()->isMahasiswa())
        @include('dashboards.mahasiswa')
    @endif
@endsection
