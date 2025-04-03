$(document).ready(function () {
    $('#request-cancel').click(function (e) {
        e.preventDefault();

        $(".reason").val("");

        $.ajax({
            url:  $(this).attr('action'),
            type:  $(this).attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(this).serialize(),
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message);
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON.status == 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });
})