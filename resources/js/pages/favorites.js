// Bookmark (remove from favorites) toggle
$(document).on('click', '.fav-btn', function () {
  const btn = $(this);
  const itemId = btn.data('id');

  $.ajax({
    url: '/favorite/toggle',
    method: 'POST',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      item_id: itemId
    },
    success: function (response) {
      if (response.action === 'removed') {
        $(`#card-${itemId}`).fadeOut(200, function () {
          $(this).remove();
          if ($('#favoritesList .favorite-card').length === 0) {
            $('#empty-favorites-alert').fadeIn(100);
          }
        });
      }
    }
  });
});

// Like toggle
$(document).on('click', '.like-btn', function () {
  const $btn = $(this);
  const userId = $btn.data('id');

  $.ajax({
    url: '/likes/toggle',
    method: 'POST',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      user_id: userId
    },
    success: function (res) {
      const liked = res.action === 'liked';
      $btn.toggleClass('text-danger', liked);
      $btn.find('i')
        .toggleClass('bi-heart-fill', liked)
        .toggleClass('bi-heart', !liked);
      $(`.like-count[data-id="${userId}"]`).text(res.like_count);
    },
    error: function () {
      if (window.toast) window.toast('error', 'Could not update like.');
    }
  });
});

// Swap form submit
$(document).on('submit', '#swapRequestForm', function (e) {
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
    success: function (response) {
      const modalElement = document.getElementById('swapModal');
      const modalInstance = window.bootstrap.Modal.getInstance(modalElement);
      if (modalInstance) modalInstance.hide();

      $form[0].reset();
      $('#swapUserId').val('');

      if (window.toast) window.toast('success', 'Swap request sent successfully');
      window.location.assign(response.redirect || '/swap');
    },
    error: function (xhr) {
      $submitButton.prop('disabled', false).text('Send Request');
      if (window.toast) window.toast('error', xhr.responseJSON?.message || 'Unable to send swap request right now');
    }
  });
});

// Open swap modal
$(document).on('click', '.open-swap-modal', function () {
  const userId = $(this).data('id');
  $('#swapUserId').val(userId);
  $('#swapRequestMessage').val('');
  showModal('swapModal');
});
