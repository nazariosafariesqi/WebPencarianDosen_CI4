$(document).on('click', '#edit-pemilik', function () {
    $('.modal-body #user_id').val($(this).data('id'));
    $('.modal-body #nama-pemilik').val($(this).data('pemilik'));
    $('.modal-body #mac-address').val($(this).data('mac'));
});