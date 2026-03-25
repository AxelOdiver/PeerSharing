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
        <p class="login-box-msg">Register to start your session</p>

        <div id="registerError" class="alert alert-danger py-2 d-none"></div>

        <form method="POST" action="{{ route('register.store') }}" id="form">
            @csrf

          <div class="input-group mb-3">
            <input
              type="text"
              name="first_name"
              class="form-control"
              placeholder="First Name"
              required
              autofocus
            >            
            <div class="invalid-feedback" data-error-for="first_name"></div>
          </div>

          <div class="input-group mb-3">
            <input
              type="text"
              name="middle_name"
              class="form-control"
              placeholder="Middle Name (Optional)"
              autofocus
            >            
            <div class="invalid-feedback" data-error-for="middle_name"></div>
          </div>

          <div class="input-group mb-3">
            <input
              type="text"
              name="last_name"
              class="form-control"
              placeholder="Last Name"
              required
              autofocus
            >
            <div class="invalid-feedback" data-error-for="last_name"></div>
          </div>

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

          <div class="input-group mb-3">
            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="Password"
              required
            >
            <span class="input-group-text" style="cursor: pointer;">
              <i class="bi bi-eye-slash-fill"></i>
            </span>
            <div class="invalid-feedback" data-error-for="password"></div>
          </div>
          
          <div class="input-group mb-3">
            <input
              type="password"
              name="password_confirmation"
              class="form-control"
              placeholder="Confirm Password"
              required
            >
            <span class="input-group-text toggle-password" style="cursor: pointer;">
              <i class="bi bi-eye-slash-fill"></i>
            </span>
            <div class="invalid-feedback" data-error-for="password_confirmation"></div>
          </div>
          
        </form>

        <div class="social-auth-links text-center mt-3 mb-3">
          <button type="submit" form="form" class="btn btn-primary w-100">Submit</button>
        </div>
        <div class="social-auth-links text-center mt-3 mb-3">
          <p>- OR -</p>
          <a href="{{ route('login') }}" class="btn btn-secondary w-100">Already have an account?</a>
        </div>
      </div>
    </div>
  </div>
@endsection
