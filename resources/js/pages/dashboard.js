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

// Event delegation for swap button clicks
$(document).on('click', '.add-swap-btn', function() {
  let btn = $(this);
  
  $.post('/swap/add', {
    _token: $('meta[name="csrf-token"]').attr('content'),
    id: btn.data('id')
  }, function() {
    btn.html('<i class="bi bi-check"></i> swapped').removeClass('btn-swap').addClass('btn-success text-white');
  });
});
