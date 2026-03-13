@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header p-1" style="max-height: 150px; overflow: hidden;"> 
          <img src="https://images.pexels.com/photos/1054218/pexels-photo-1054218.jpeg?_gl=1*k7b7ow*_ga*ODI0MzA5MzAwLjE3NzM0MTU5NzY.*_ga_8JE65Q40S6*czE3NzM0MTU5NzYkbzEkZzEkdDE3NzM0MTU5NzgkajU4JGwwJGgw" class="card-img-top" />
        </div>
        <div class="card-body">
          <h5 class="card-title">Welcome back</h5>
          <p class="card-text mb-0">
            Signed in as <strong>{{ auth()->user()->name ?? 'User' }}</strong>.
          </p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header p-1" style="max-height: 150px; overflow: hidden;"> 
          <img src="https://images.pexels.com/photos/1054218/pexels-photo-1054218.jpeg?_gl=1*k7b7ow*_ga*ODI0MzA5MzAwLjE3NzM0MTU5NzY.*_ga_8JE65Q40S6*czE3NzM0MTU5NzYkbzEkZzEkdDE3NzM0MTU5NzgkajU4JGwwJGgw" class="card-img-top" />
        </div>
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
