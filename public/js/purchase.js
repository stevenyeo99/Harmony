$(document).ready(function() {
    initializeDatePicker();
    addNewRowItemDetail();
    dropdownSupplierEvent();
    initializeChosenDropdown();
    setItemDetailPrice();
    setSubTotalEachItemDetail();
    setSubTotalPurchaseItem();
    submitPurchaseForm();
});

// used for itemdetail list
var globalItemDetailList = [];

function initializeDatePicker() {
    $('#purchase_datetime').datepicker({
        dateFormat: 'yy-mm-dd',
    });
}

function deleteRowItemDetail(deleteIcon) {
    var currentRow = deleteIcon.parent().parent();
    currentRow.remove();
    resetItemBodyDetails();
    setSubTotalPurchaseItem();
}

/**
 * method to reset item body details each number when got action of add row, delete rows
 */
function resetItemBodyDetails() {
    var number = 1;
    $('#tablePurchaseDetail tbody tr').each(function() {
        var currentRow = $(this);
        currentRow.find('td:eq(0)').text(number + '.');
        currentRow.find('td:eq(1) select').attr('name', 'itdt[' +  number + '][itdt_id]');
        currentRow.find('td:eq(2) input').attr('name', 'itdt[' +  number + '][quantity]');
        currentRow.find('td:eq(3) input').attr('name', 'itdt[' +  number + '][price]');
        currentRow.find('td:eq(4) input').attr('name', 'itdt[' +  number + '][sub_total]');
        number++;
    });
}

function addNewRowItemDetail() {
    $('#addItem').click(function() {
        var itemRow = "<tr>";
        itemRow += "<td style='text-align: right;'></td>";
        itemRow += "<td class='text-center'><select class='ddlChosen'><option value = ''>-- Pilih Item --</option>";
        
        for (var index in globalItemDetailList) {
            itemRow += "<option value='" + globalItemDetailList[index].itdt_id + "'>" + globalItemDetailList[index].name + "</option>";
        }

        itemRow += "</select></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput harmonyAmountInput txtItemQuantity' onkeypress='return isNumberPercentage(event, $(this))'></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput' readonly></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput' readonly></td>";
        itemRow += "<td class='text-center' style='width: 5%;'><img class='deleteItemRow' src='/img/delete.png' style='cursor: pointer; width: 2rem; height: 2rem;' onclick='deleteRowItemDetail($(this))'></td>";
        itemRow += "</tr>";

        var tableItemElement = $('#tablePurchaseDetail');
        tableItemElement.find('tbody').append(itemRow);
        
        resetItemBodyDetails();
        initializeChosenDropdown();
        bindAmountOnChange();
        setItemDetailPrice();
        setSubTotalEachItemDetail();
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
    $('#splr_id').change(function() {
        var splr_id = $(this).val();
        $.ajax({
            url: "/manage_purchase/ajax/supplier_item/" + splr_id,
            method: "GET",
            success: function(data) {
                globalItemDetailList = data;
                configureEachItemDetail();
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
}

function configureEachItemDetail() {
    var itemDetailRow = $('#tablePurchaseDetail tbody tr');

    itemDetailRow.each(function() {
        var currentRow = $(this);
        
        var quantity = currentRow.find('td:eq(2) input');
        var price = currentRow.find('td:eq(3) input');
        var totalPrice = currentRow.find('td:eq(4) input');

        quantity.val('');
        price.val('');
        totalPrice.val('');
    });

    setItemDetailDropdown();
    setSubTotalPurchaseItem();
}

/**
 * method for set option 
 */
function setItemDetailDropdown() {
    $('#tablePurchaseDetail tbody tr').each(function () {
        var currentRow = $(this);

        var dropdown = currentRow.find('td:eq(1) select.ddlChosen');

        dropdown.children().remove();

        dropdown.append("<option value = ''>-- Pilih Item --</option>");

        for (var index in globalItemDetailList) {
            var obj = $(this);
            var optionItem = "<option value = '" + globalItemDetailList[index].itdt_id +"'>" + globalItemDetailList[index].name + "</option>";

            dropdown.append(optionItem);
        }

        dropdown.trigger('chosen:updated');
    });
}

/**
 * method for set item detail price (chosen item)
 */
function setItemDetailPrice() {
    $('.ddlChosen').change(function() {
        var element = $(this);
        var priceElement = $(this).parent().parent().find('td:eq(3) input');
        var subTotal = $(this).parent().parent().find('td:eq(4) input');
        if (element.val() !== '') {
            for (var index in globalItemDetailList) {
                var itdt_id = parseInt(element.val());
                if (itdt_id === globalItemDetailList[index].itdt_id) {                  
                    priceElement.val(getPriceFormattedNumber(globalItemDetailList[index].price, 2));

                    var quantityElement = $(this).parent().parent().find('td:eq(2) input');

                    if (quantityElement.val() !== '') {
                        quantityElement.change();
                    }
                }
            }
        } else {
            // set price empty
            priceElement.val('');
            subTotal.val('');
            setSubTotalPurchaseItem();
        }
    });
}

/**
 * method for sub total each row purchase item
 */
function setSubTotalEachItemDetail() {
    $('.txtItemQuantity').change(function() {
        var element = $(this);

        var currentRow = element.parent().parent();
        
        var ddlItem = currentRow.find('td:eq(1) select.ddlChosen');

        var subTotalElem = currentRow.find('td:eq(4) input');

        if (ddlItem.val() !== '') {
            var itdt_id = parseInt(ddlItem.val());

            for (var index in globalItemDetailList) {
                if (itdt_id === globalItemDetailList[index].itdt_id) {
                    // validate item quantity cannot exceed then limit
                    var price = parseFloat(globalItemDetailList[index].price);
                    var currentQty = parseFloat(element.val());
                    
                    var subTotal = getPriceFormattedNumber(price * currentQty, 2);

                    subTotalElem.val(subTotal);

                    setSubTotalPurchaseItem();
                }
            }
        }
    });
}

/**
 * method for sub total purchase item
 */
function setSubTotalPurchaseItem() {
    var subTotal = 0;
    $('#tablePurchaseDetail tbody tr').each(function() {
        var totalPriceItem = $(this).find('td:eq(4) input').val();
        if (totalPriceItem === '') {
            totalPriceItem = 0;
        }
        
        subTotal += parseFloat(removeNumberFormat(totalPriceItem));
    });
    $('#sub_total').val(getPriceFormattedNumber(subTotal, 2));
}

/**
 * method for validating purchase form
 */
function validatePurchaseForm() {
    var valid = true;
    
    // validate purchase form
    // 1. supplier dropdown
    // 2. purchase date cannot empty
    // 3. validate must exist at least 1 item
    // 4. each item detail
    // 5. validate cannot duplicated item detail

    var supplier = $('#splr_id');

    if (supplier.val() === '') {
        alert('Supplier wajib dipilih untuk melakukan pembelian!');
        scrollTo(supplier.next());
        supplier.focus();
        return false;
    }

    var purchase_datetime = $('#purchase_datetime');

    if (purchase_datetime.val() === '') {
        alert('Tanggal PO wajib dipilih');
        scrollTo(purchase_datetime);
        purchase_datetime.focus();
        return false;
    }

    var itemDetailRow = $('#tablePurchaseDetail tbody tr');

    if (itemDetailRow.length == 0) {
        alert('Tidak terdapat item yang akan dibeli!');
        $('#addItem').click();
        return false;
    }

    var index = 1;
    var itdtValidArr = [];
    itemDetailRow.each(function() {
        var currentRow = $(this);
        var itdt_id = $(this).find('td:eq(1) select');
        var quantity = $(this).find('td:eq(2) input');
        
        if (itdt_id.val() === '') {
            alert('Item Pembelian pada baris no. ' + index + ' harap dipilih');
            scrollTo(itdt_id.next());
            itdt_id.next().addClass('chosen-container-active');
            valid = false;
            return false;
        } else if (itdtValidArr.includes(itdt_id.val())) {
            alert('Item Pembelian pada baris no. ' + index + ' terjadi duplikat pemilihan');
            scrollTo(itdt_id.next());
            itdt_id.next().addClass('chosen-container-active');
            valid = false;
            return false;
        }

        if (quantity.val() === '') {
            alert('Kuantiti Item pembelian pada baris no. ' + index + ' Harap diisi');
            scrollTo(quantity);
            quantity.focus();
            valid = false;
            return false;
        }

        itdtValidArr.push(itdt_id.val());
        index++;
    });

    return valid;
}

/**
 * method for submit purchase request
 */
function submitPurchaseForm() {
    $('#btnSave').click(function() {
        if (validatePurchaseForm()) {
            $('#confirmModal').modal('show');
        } 
    });
}