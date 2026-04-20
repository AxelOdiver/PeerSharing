$(document).ready(function () {
    
    // ENTER EDIT MODE
    $('#editDescriptionBtn').on('click', function() {
        $('#descriptionViewMode').hide();       
        $('#descriptionEditMode').show();       
        $(this).hide();                         
    });
    
    // CANCEL EDIT
    $('#cancelEditBtn').on('click', function() {
        const currentText = $('#descriptionText').text().trim();
        $('#descriptionInput').val(currentText === 'No description yet.' ? '' : currentText);
        
        $('#descriptionEditMode').hide();       
        $('#descriptionViewMode').show();       
        $('#editDescriptionBtn').show();        
    });
    
    // SAVE EDIT 
    $('#saveEditBtn').on('click', function() {
        const communityId = $('#editDescriptionBtn').data('id');
        const newDescription = $('#descriptionInput').val().trim();
        const $saveBtn = $(this);
        
        if (!newDescription) {
            window.toast('error', 'Description cannot be empty.');
            return;
        }
        
        $saveBtn.prop('disabled', true).text('Saving...');
        
        $.ajax({
            url: `/community/${communityId}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                description: newDescription
            },
            success: function (response) {
                $('#descriptionText').text(newDescription);
                
                $('#descriptionEditMode').hide();
                $('#descriptionViewMode').show();
                $('#editDescriptionBtn').show();
                
                window.toast('success', 'Description updated successfully!');
            },
            error: function (xhr) {
                window.toast('error', 'Failed to update description.');
                console.error(xhr.responseJSON?.message || 'Error occurred.');
            },
            complete: function() {
                $saveBtn.prop('disabled', false).text('Save');
            }
        });
    });
    
    $('#editTagsForm').on('submit', function(e) {
        e.preventDefault();
        
        let $form = $(this);
        let communityId = $('#editTagsCommunityId').val();
        let formData = $form.serialize(); 
        let $btn = $('#saveTagsBtn');
        
        // Show a loading state on the button
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...');
        
        // Clear old validation errors
        clearErrors($form);
        
        $.ajax({
            url: `/community/${communityId}/tags`,
            type: 'POST', 
            data: formData,
            dataType: 'json',
            headers: {
                'Accept': 'application/json'
            },
            success: function(response) {
                // Close modal and show success toast
                hideModal('editTagsModal');
                toast('success', response.message);
                
                // Refresh the page after 1.5s to show the newly saved tags
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                // Reset button if there is an error
                $btn.prop('disabled', false).text('Save Tags'); 
                
                if (xhr.status === 422) {
                    showFormErrors($form, xhr.responseJSON.errors);
                } else {
                    toast('error', xhr.responseJSON?.message || 'Something went wrong while saving tags.');
                }
            }
        });
    });
    
    // Create Post AJAX Logic
    $('#createPostForm').on('submit', function(e) {
        e.preventDefault();
        
        let $form = $(this);
        let communityId = $('#communityIdForPost').val();
        let formData = $form.serialize(); 
        let $btn = $('#savePostBtn');
        
        // Loading state
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Posting...');
        
        clearErrors($form);
        
        $.ajax({
            url: `/community/${communityId}/posts`,
            type: 'POST', 
            data: formData,
            dataType: 'json',
            headers: { 'Accept': 'application/json' },
            success: function(response) {
                hideModal('createPostModal');
                toast('success', response.message);
                
                // Clear the form inputs for the next time it opens
                $form[0].reset();
                
                // Refresh to show the new post in the feed
                setTimeout(() => {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                $btn.prop('disabled', false).text('Post'); 
                
                if (xhr.status === 422) {
                    showFormErrors($form, xhr.responseJSON.errors);
                } else {
                    toast('error', xhr.responseJSON?.message || 'Something went wrong while posting.');
                }
            }
        });
    });

    // --- DELETE POST OR COMMENT METHOD ---
  $(document).on('click', '.delete-post-btn, .delete-comment-btn', async function(e) {
    e.preventDefault(); 
    
    const $btn = $(this).closest('button');
    const url = $btn.data('url');
    
    // Determine if we clicked a post or a comment for the alert text
    const itemType = $btn.hasClass('delete-post-btn') ? 'post' : 'comment';
    
    const result = await window.confirmAction(
      `Are you sure you want to delete this ${itemType}? This action cannot be undone.`,
      `Delete ${itemType.charAt(0).toUpperCase() + itemType.slice(1)}?`
    );
    
    if (result.isConfirmed) {
      $.ajax({
        url: url,
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
          // Capitalize the first letter for the success toast
          const capitalizedType = itemType.charAt(0).toUpperCase() + itemType.slice(1);
          window.toast('success', response.message || `${capitalizedType} deleted successfully.`);
          
          // Reload the page to show the item is gone
          setTimeout(() => location.reload(), 1000);
        },
        error: function (xhr) {
          const errorMessage = xhr.responseJSON?.message || `Failed to delete ${itemType}.`;
          window.toast('error', errorMessage);
        },
      });
    }
  });
    
});