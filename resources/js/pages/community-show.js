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

});