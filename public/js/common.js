$(document).ready(function () {
    save();
    trigProcessingDelete();
});

function save() {
    $('#btnSaveConfirm').click(function () {
        $('#frm').submit();
    });
}

function trigDeleteModalBtn(data) {
    $('#frmModalDelete').attr('action', data);
    $('#deleteModal').modal();
}

function trigProcessingDelete() {
    $('#btnDelConfirm').click(function() {
        $('#frmModalDelete').submit();
    });
}
