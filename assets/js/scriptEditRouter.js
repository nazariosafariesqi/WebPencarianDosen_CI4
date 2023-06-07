$(document).on('click', '#edit-router', function () {
    $('.modal-body #user_id').val($(this).data('id'));
    $('.modal-body #nama-router').val($(this).data('nama'));
    $('.modal-body #ip-edit').val($(this).data('ip'));

});