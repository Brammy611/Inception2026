@extends('layouts.app')

@section('content')
  {{-- Home Section --}}
  @include('sections.home')

  {{-- About Section --}}
  @include('sections.about')

  {{-- Organization Section --}}
  @include('sections.organization')

  {{-- Events Section --}}
  @include('sections.events')

  {{-- Competition Section --}}
  @include('sections.competition')

  {{-- Timeline Section --}}
  @include('sections.timeline')
@endsection