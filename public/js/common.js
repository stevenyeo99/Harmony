$(document).ready(function () {
    save();
});

function save() {
    $('#btnSaveConfirm').click(function () {
        $('#frm').submit();
    });
}
