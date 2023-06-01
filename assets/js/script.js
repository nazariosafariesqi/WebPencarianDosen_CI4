$(document).on('click', '#btn-edit', function () {
    $('.modal-body #user_id').val($(this).data('id'));
    $('.modal-body #name-edit').val($(this).data('name'));
    $('.modal-body #email-edit').val($(this).data('email'));
});