@extends('layouts.dashboard')

@section('title', 'Community')
@section('page-title', 'Community')

@section('content')
<div class="container-fluid py-4">
  
  <a href="{{ route('community') }}" class="btn btn-primary mb-4">
    <i class="bi bi-arrow-left"></i> Back to Communities
  </a>
  
  <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <h1 class="fw-bold">{{ $community->name }}</h1>
    <div class="text-muted mb-3">
      <i class="bi bi-person-circle me-1"></i> Created by {{ $community->user?->first_name }} {{ $community->user?->last_name ?? 'Unknown' }}
      <span class="mx-2">|</span>
      <i class="bi bi-people-fill me-1"></i> Member Limit: {{ $community->member_limit }}
    </div>
    <p class="lead">{{ $community->description }}</p>
  </div>
  
  <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
    <h3 class="text-muted">Welcome to the {{ $community->name }} community!</h3>
    <p class="text-muted mb-0">This is where you will add posts, files, or chat features later.</p>
  </div>
  
</div>
@endsection