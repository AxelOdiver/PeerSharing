// Event delegation for favorite button clicks
$(document).on('click', '.fav-btn', function() {
  let btn = $(this);
  let itemId = btn.data('id');
  
  $.ajax({
    url: '/favorite/toggle',
    method: "POST",
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      item_id: itemId
    },
    success: function(response) {
      if (response.action === 'swapped') {
        btn.html('<i class="bi bi-bookmark-fill text-warning"></i>');
      } else {
        btn.html('<i class="bi bi-bookmark"></i>');
      }
    },
    error: function(xhr) {
      console.log("Error:", xhr.responseText);
    }
  });
});

$(document).on('submit', '#swapRequestForm', function(e) {
  e.preventDefault();

  const $form = $(this);
  const $submitButton = $('#sendSwapRequestBtn');

  $submitButton.prop('disabled', true).text('Sending...');

  $.ajax({
    url: '/swap/add',
    method: 'POST',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      user_id: $('#swapUserId').val(),
      message: $('#swapRequestMessage').val()
    },
    success: function(response) {
      const modalElement = document.getElementById('swapModal');
      const modalInstance = window.bootstrap.Modal.getInstance(modalElement);

      if (modalInstance) {
        modalInstance.hide();
      }

      $form[0].reset();
      $('#swapUserId').val('');

      if (window.toast) {
        window.toast('success', 'Swap request sent successfully');
      }

      window.location.assign(response.redirect || '/swap');
    },
    error: function(xhr) {
      $submitButton.prop('disabled', false).text('Send Request');

      if (window.toast) {
        window.toast('error', xhr.responseJSON?.message || 'Unable to send swap request right now');
      }
    }
  });
});

// Open swap modal and set user ID
$(document).on('click', '.open-swap-modal', function() {
  const userId = $(this).data('id');
  $('#swapUserId').val(userId);
  $('#swapRequestMessage').val('');
  showModal('swapModal');
});
