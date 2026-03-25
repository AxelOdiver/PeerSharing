// Profile edit page - form submission
$(document).ready(function() {
  const $form = $('#form');

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
        toast('success', 'Profile updated successfully!');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
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

        toast('error', 'Sorry, something went wrong. Please try again.');
      }
    });
  });
});
