$(document).ready(function() {
    $('#payment-status').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        location.reload()
                    }, 2000)
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });
});