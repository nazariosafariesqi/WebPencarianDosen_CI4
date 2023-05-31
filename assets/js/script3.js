$(document).on('click', '#edit-ruangan', function () {
    $('.modal-body #user_id').val($(this).data('id'));
    $('.modal-body #no-ruang').val($(this).data('no'));
    $('.modal-body #nama-ruang').val($(this).data('ruang'));
    $('.modal-body #gateway-edit').val($(this).data('gateway'));
    $('.modal-body #lantai').val($(this).data('lantai'));
});