@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
  <div class="row">
    <div class="col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Welcome back</h5>
          <p class="card-text mb-0">
            Signed in as <strong>{{ auth()->user()->name ?? 'User' }}</strong>.
          </p>
        </div>
      </div>
    </div>
  </div>
@endsection
