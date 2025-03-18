$(document).ready(function () {
    $('#clear-cart').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON.status == 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        })
    })

    let clickedAction = '';


    $('#update-cart button[type=submit]').click(function () {
        clickedAction = $(this).val();
    });

    $('#update-cart').submit(function (e) {
        e.preventDefault();


        $('#update-cart input[name=action]').remove();

        $('#update-cart').append(`<input type="hidden" name="action" value="${clickedAction}">`);

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success') {
                    if (clickedAction === 'filter') {
                        setTimeout(() => {
                            window.location.href = orderIndexUrl;
                        }, 500);
                    } else {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }


                }
            },
            error: function (xhr) {
                console.log(xhr);
                toastr.error(xhr.responseJSON?.message);
            }
        });
    });

    $('.delete-item-cart').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON.status == 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });

});