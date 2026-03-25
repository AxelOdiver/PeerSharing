// Register page - password toggle and form submission
$(document).ready(function() {
  const $form = $('#form');

  // Password show/hide toggle
  $(document).on('click', '.toggle-password', function() {
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
    $form.find('[data-error-for]').text('');
    $('#registerError').addClass('d-none').text('');
  }

  $form.on('submit', function(e) {
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
      success: function(response) {
        sessionStorage.setItem('toast', JSON.stringify({
          type: 'success',
          message: response.message ?? 'Registration successful!',
        }));

        window.location.href = response.redirect ?? '/dashboard';
      },
      error: function(xhr) {
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

        $('#registerError').removeClass('d-none').text('Sorry, something went wrong. Please try again.');
      }
    });
  });
});
