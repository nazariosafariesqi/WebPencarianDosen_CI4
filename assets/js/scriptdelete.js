$(document).on('click', '#btn-delete', function () {
    $('.modal-body #user_id').val($(this).data('delete'));
});