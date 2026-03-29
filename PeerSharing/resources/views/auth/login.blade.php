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

          <div class="input-group mb-3 toggle-password" style="cursor: pointer;">
            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="Password"
              required
            >
            <span class="input-group-text">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const $form = $('#form');

    // Password show/hide toggle 
  $('.toggle-password').on('click', function() {
      const $input = $(this).closest('.input-group').find('input');
      const $icon = $(this).find('i');

      if ($input.attr('type') === 'password') {
          $input.attr('type', 'text');
          $icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
      } else {
          $input.attr('type', 'password');
          $icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
      }
  });

  // Submit form logic 
  function clearErrors() {
    $form.find('.is-invalid').removeClass('is-invalid');
    $('[data-error]').text('');
  }

  $form.on('submit', function (e) {
    e.preventDefault();
    clearErrors();

    $.ajax({
      url: $form.attr('action'),
      method: 'POST',
      data: $form.serialize(),
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        window.location.assign(response.redirect);
      },
      error: function (xhr) {
        if (xhr.status === 422) {
          const errors = xhr.responseJSON?.errors || {};
          for (const field in errors) {
            const msg = errors[field]?.[0] ?? 'Invalid input';
            const $input = $form.find(`[name="${field}"]`);
            $input.addClass('is-invalid');
            $form.find(`[data-error-for="${field}"]`).text(msg);
          }
          return;
        }

        // 401 invalid credentials (or other errors)
        const msg = xhr.responseJSON?.message ?? 'Login failed';
        $('#loginError').removeClass('d-none').text(msg);
      }
    });
  });
});
</script>
@endpush