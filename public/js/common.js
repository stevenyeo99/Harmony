$(document).ready(function () {
    save();
    trigProcessingDelete();
    trigProcessingApprove();
    bindAmountOnChange();
    initializeCommonChosenDropdown();
});

function initializeCommonChosenDropdown() {
    // each row item
    var element = 'select.ddlChosen';
    $(element).chosen();
    $(element).siblings().css("width", "100%");
}

function save() {
    $('#btnSaveConfirm').click(function () {
        $('#frm').submit();
    });
}

function trigDeleteModalBtn(data) {
    $('#frmModalDelete').attr('action', data);
    $('#deleteModal').modal();
}

function trigApproveModalBtn(data) {
    $('#frmModalApprove').attr('action', data);
    $('#approveModal').modal();
}

function trigProcessingDelete() {
    $('#btnDelConfirm').click(function() {
        $('#frmModalDelete').submit();
    });
}

function trigProcessingApprove() {
    $('#btnAccConfirm').click(function() {
        $('#frmModalApprove').submit();
    });
}

function isNumberPlusComma(event, currentInputEntry) {
    var key = window.event ? event.keyCode : event.which;
    //    alert(event.keyCode);
    // 46 is dot
    if (event.keyCode === 8 || event.keyCode === 46) {
        if (event.keyCode === 46 && currentInputEntry.val().indexOf('.') === -1) {
            currentInputEntry.data('dot', 1);
        } else {
            return false;
        }
        return true;
    } else if (key < 48 || key > 57) {
        return false;
    } else {
        return true;
    }
}

// for percentage input selected
function isNumberPercentage(event, currentInputEntry) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        if (event.keyCode === 46 && currentInputEntry.val().indexOf('.') === -1) {
            currentInputEntry.data('dot', 1);
        } else {
            return false;
        }
    } else if (key < 48 || key > 57) {
        return false;
    } else {
        return true;
    }
}

function bindAmountOnChange() {
    $('.harmonyAmountInput').change(function () {
        var thisInputAmount = $(this);
        if (thisInputAmount.val().trim() === '.' || thisInputAmount.val().trim() === '') {
            thisInputAmount.val('0.00');
        }

        // if empty keep the value empty
        if (thisInputAmount.val() !== '') {
            $(thisInputAmount).val(getPriceFormattedNumber(thisInputAmount.val(), 2));
        }
    });
}

function getPriceFormattedNumber(number, numberOfDecimalPlaces) {
    number = removeNumberFormat(number);
    var roundingFactor = Math.pow(10, numberOfDecimalPlaces);
    //round up, and set to 4 decimal places (Eg. 1.34567 -> 1.3457)
    //add a small epsilon number (0.00000001) 
    //in cases where 554144.445 * 100 = 55414444.49999999
    //that will result in an inaccurate rounding, 
    //adding the epsilon value after mulitpling will fix that
    number = (Math.round((number * roundingFactor) + (0.0001 / roundingFactor)) / roundingFactor).toFixed(numberOfDecimalPlaces);
    //format numbers with commas
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function removeNumberFormat(number) {
    number = number.toString();
    number = number.replace(/,/g, "");
    number = number.replace(/\$/g, "");

    return number;
}

function scrollTo(element)
{
    $('html, body').stop().animate({
        scrollTop: element.offset().top
    }, 1000);
}

function fnOpenPopUpWindow(windowName, URL) {
    var availHeight = screen.availHeight;
    var availWidth = screen.availWidth;
    var x = 0, y = 0;
    if (document.all) {
        x = window.screentop;
        y = window.screenLeft;
    } else if (document.layers) {
        x = window.screenX;
        y = window.screenY;
    }
    var windowArguments = 'resizable=1,toolbar=0,location=0,directories=0,addressbar=0,scrollbars=1,status=1,menubar=0,top=0,left=0, ';
    windowArguments += 'screenX=' + x + ',screenY=' + y + ',width=' + availWidth + ',height=' + availHeight;

    var newWindow = window.open(URL, windowName, windowArguments);
    newWindow.moveTo(0, 0);

    return newWindow;
}