$(document).ready(function() {
    initializeDatePicket();
    dateFromPickerChangeEvent();
    dateToPickerChangeEvent();
    triggerExportEvent();
});

// function initialize date picket
function initializeDatePicket() {
    $('#date_from').datepicker({
        dateFormat: 'yy-mm-dd',
    });

    $('#date_to').datepicker({
        dateFormat: 'yy-mm-dd',
    });
}

/**
 * date picker from change event
 */
function dateFromPickerChangeEvent() {
    $('#date_from').change(function() {
        var date_from = $('#date_from');
        if (date_from.val() !== '') {
            var date_from_split = date_from.val().split('-');
            var day = date_from_split[2];
            var month = date_from_split[1];
            var year = date_from_split[0];
            $('#date_to').datepicker('destroy');
            $('#date_to').datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: new Date(year, month - 1, day),
            });
        }
    });
}

/**
 * date picker to change event
 */
function dateToPickerChangeEvent() {
    $('#date_to').change(function() {
        var date_to = $('#date_to');
        if (date_to.val() !== '') {
            var date_to_split = date_to.val().split('-');
            var day = date_to_split[2];
            var month = date_to_split[1];
            var year = date_to_split[0];
            $('#date_from').datepicker('destroy');
            $('#date_from').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: new Date(year, month - 1, day),
            });
        }
    });
}

/**
 * validate export report form
 */
function validateExportReportFrom() {
    var date_from = $('#date_from');
    if (date_from.val() === '') {
        alert('Mohon tanggal dari dipilih!');
        scrollTo(date_from);
        date_from.focus();
        return false;
    }

    var date_to = $('#date_to');
    if (date_to.val() === '') {
        alert('Mohon tanggal ke dipilih!');
        scrollTo(date_to);
        date_to.focus();
        return false;
    }

    return true;
}

/**
 * trigger export request
 */
function triggerExportEvent() {
    $('#btnExport').click(function() {
        if (validateExportReportFrom()) {
            $('#frm').submit();
        }
    });
}