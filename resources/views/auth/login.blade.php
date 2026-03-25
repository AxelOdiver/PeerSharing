@extends('layouts.auth')

@section('title', 'Login')
@section('body-class', 'login-page bg-body-tertiary')

@section('content')
  <div class="login-box">

    <div class="login-logo">
      <a href="{{ url('/') }}"><b>Peer</b>Hive</a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Login in to start your session</p>

        <div id="loginError" class="alert alert-danger py-2 d-none"></div>

        <form method="POST" action="{{ route('login.store') }}" id="form">
            @csrf

          <div class="input-group mb-3">
            <input
              type="text"
              name="email"
              class="form-control"
              placeholder="Email"
              required
              autofocus
            >
            <span class="input-group-text">
              <i class="bi bi-envelope"></i>
            </span>
            <div class="invalid-feedback" data-error-for="email"></div>
          </div>

          <div class="input-group mb-3" style="cursor: pointer;">
            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="Password"
              required
            >
            <span class="input-group-text toggle-password">
              <i class="bi bi-eye-slash-fill"></i>
            </span>
            <div class="invalid-feedback" data-error-for="password"></div>
          </div>
          <button type="submit" class="btn btn-primary w-100">
            Login
          </button>
          
        </form>

        <div class="social-auth-links text-center mt-3 mb-3">
          <p>- OR -</p>
          <a href="{{ route('register') }}" class="btn btn-secondary w-100">Register</a>
      </div>
    </div>

  </div>
@endsection