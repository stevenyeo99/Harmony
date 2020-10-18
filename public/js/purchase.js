$(document).ready(function() {
    addNewRowItemDetail();
    dropdownSupplierEvent();
    initializeChosenDropdown();
    dropdownSupplierEvent();
});

function deleteRowItemDetail(deleteIcon) {
    var currentRow = deleteIcon.parent().parent();
    currentRow.remove();
    resetItemBodyDetails();
}

/**
 * method to reset item body details each number when got action of add row, delete rows
 */
function resetItemBodyDetails() {
    var number = 1;
    $('#tablePurchaseDetail tbody tr').each(function() {
        var currentRow = $(this).find('td:eq(0)');
        currentRow.text(number + '.');
        number++;
    });
}

function addNewRowItemDetail() {
    $('#addItem').click(function() {
        var itemRow = "<tr>";
        itemRow += "<td style='text-align: right;'></td>";
        itemRow += "<td class='text-center'><select class='ddlChosen'><option value = ''>-- Pilih Item --</option></select></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput'></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput' readonly></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput' readonly></td>";
        itemRow += "<td class='text-center' style='width: 5%;'><img class='deleteItemRow' src='/img/delete.png' style='cursor: pointer; width: 2rem; height: 2rem;' onclick='deleteRowItemDetail($(this))'></td>";
        itemRow += "</tr>";

        var tableItemElement = $('#tablePurchaseDetail');
        tableItemElement.find('tbody').append(itemRow);
        
        resetItemBodyDetails();
        initializeChosenDropdown();
    });
}

function initializeChosenDropdown() {
    // each row item
    var element = 'select.ddlChosen';
    $(element).chosen();
    $(element).siblings().css("width", "100%");

    // supplier dropdown
    var element1 = 'select#splr_id';
    $(element1).chosen();
    $(element1).siblings().css("width", "100%");
}

// method for ajax request by supplier on change to get item base of supplier
function dropdownSupplierEvent() {
    
}