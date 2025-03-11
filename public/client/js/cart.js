$(document).ready(function() {
    $('#clear-cart').click(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status == 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON.status == 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        })
    })

    $('#update-cart').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            },
            error: function (xhr) {
                if(xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });

    $('.delete-item-cart').click(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status == 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON.status == 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });
});