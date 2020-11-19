$(document).ready(function() {
    initializeItemDetailData();
    addNewRowInvoiceItemDetail();
    setSubTotalEachInvoiceItemDetail();
    setSubTotalInvoiceItem();
    calculationReturnAmount();
    submitInvoiceForm();
    resetInvoiceItemBodyDetails();
    initializeDatePickerEditTransaction();
    automateTriggerPrint();
    proceedTransaction();
    $('#return_amt').val(getPriceFormattedNumber($('#return_amt').val(), 2));
});

// used for invoice itemdetail list
var globalInvoiceItemDetailList = [];

function initializeItemDetailData() {
    $.ajax({
        url: "/manage_invoice/ajax/invoice_item",
        method: "GET",
        success: function(data) {
            globalInvoiceItemDetailList = data;
        }, 
        error: function(data) {
            console.log(data);
        }
    })
}

function initializeDatePickerEditTransaction() {
    var transactionDate = $('#txtInvoiceDateTime').val();
    if (typeof transactionDate !== 'undefined') {
        if (transactionDate !== '') {
            var arrayDate = transactionDate.split("-");
            var day = arrayDate[2];
            var month = arrayDate[1];
            var year = arrayDate[0];
            $('#txtInvoiceDateTime').datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: new Date(year, month - 1, day),
            });
        }
    }
}

function resetInvoiceItemBodyDetails() {
    var number = 1;
    $('#tableInvoiceDetail tbody tr').each(function() {
        var currentRow = $(this);
        currentRow.find('td:eq(0)').text(number + '.');
        currentRow.find('td:eq(1) select').attr('name', 'itdt[' +  number + '][itdt_id]');
        currentRow.find('td:eq(2) input').attr('name', 'itdt[' +  number + '][quantity]');
        currentRow.find('td:eq(3) input').attr('name', 'itdt[' +  number + '][price]');
        currentRow.find('td:eq(4) input').attr('name', 'itdt[' +  number + '][sub_total]');
        number++;
    });
}

function addNewRowInvoiceItemDetail() {
    $('#addInvoiceItem').click(function() {
        var itemRow = "<tr>";
        itemRow += "<td style='text-align: right;'></td>";
        itemRow += "<td class='text-center'><select class='ddlChosen'><option value = ''>-- Pilih Item --</option>";

        for (var index in globalInvoiceItemDetailList) {
            itemRow += "<option value='" + globalInvoiceItemDetailList[index].itdt_id + "'>" + globalInvoiceItemDetailList[index].name + "</option>";
        }

        itemRow += "</select></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput harmonyAmountInput txtItemQuantity' onkeypress='return isNumberPercentage(event, $(this));'></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput' readonly></td>";
        itemRow += "<td class='text-center'><input type='text' class='form-control amountPercentInput' readonly></td>";
        itemRow += "<td class='text-center' style='width: 5%;'><img class='deleteItemRow' src='/img/delete.png' style='cursor: pointer; width: 2rem; height: 2rem;' onclick='deleteInvoiceRowItemDetail($(this))'></td>";
        itemRow += "</tr>";

        var tableItemElement = $('#tableInvoiceDetail');
        tableItemElement.find('tbody').append(itemRow);

        resetInvoiceItemBodyDetails();
        initializeChosenDropdown();
        bindAmountOnChange();
        setInvoiceItemDetailPrice();
        setSubTotalEachInvoiceItemDetail();
    });
}

function deleteInvoiceRowItemDetail(deleteIcon) {
    var currentRow = deleteIcon.parent().parent();
    currentRow.remove();
    resetInvoiceItemBodyDetails();
    setSubTotalInvoiceItem();
}

function initializeChosenDropdown() {
    var element = 'select.ddlChosen';
    $(element).chosen();
    $(element).siblings().css("width", "100%");
}

function setInvoiceItemDetailPrice() {
    $('.ddlChosen').change(function() {
        var element = $(this);
        var priceElement = $(this).parent().parent().find('td:eq(3) input');
        var subTotal = $(this).parent().parent().find('td:eq(4) input');
        if (element.val() !== '') {
            for (var index in globalInvoiceItemDetailList) {
                var itdt_id = parseInt(element.val());
                if (itdt_id === globalInvoiceItemDetailList[index].itdt_id) {
                    priceElement.val(getPriceFormattedNumber(globalInvoiceItemDetailList[index].price, 2));

                    var quantityElement = $(this).parent().parent().find('td:eq(2) input');

                    if (quantityElement.val() !== '') {
                        quantityElement.change();
                    }
                }
            }
        } else {
            priceElement.val('');
            subTotal.val('');
            setSubTotalInvoiceItem();
        }
    });
}

function setSubTotalEachInvoiceItemDetail() {
    $('.txtItemQuantity').change(function() {
        var element = $(this);

        var currentRow = element.parent().parent();

        var ddlItem = currentRow.find('td:eq(1) select.ddlChosen');

        var subTotalElem = currentRow.find('td:eq(4) input');

        if (ddlItem.val() !== '') {
            var itdt_id = parseInt(ddlItem.val());

            for (var index in globalInvoiceItemDetailList) {
                if (itdt_id === globalInvoiceItemDetailList[index].itdt_id) {
                    var price = parseFloat(globalInvoiceItemDetailList[index].price);
                    var currentQty = parseFloat(element.val());

                    var subTotal = getPriceFormattedNumber(price * currentQty, 2);

                    subTotalElem.val(subTotal);

                    setSubTotalInvoiceItem();
                }
            }
        }
    });
}

function setSubTotalInvoiceItem() {
    var subTotal = 0;
    $('#tableInvoiceDetail tbody tr').each(function() {
        var totalPriceItem = $(this).find('td:eq(4) input').val();
        if (totalPriceItem === '') {
            totalPriceItem = 0;
        }

        subTotal += parseFloat(removeNumberFormat(totalPriceItem));
    });

    $('#invoice_sub_total').val(getPriceFormattedNumber(subTotal, 2));

    $('#paid_amt').change();
}

function calculationReturnAmount() {
    $('#paid_amt').change(function() {
        var paidElement = $(this);
        var subTotalElement = $('#invoice_sub_total');
        var returnAmtElement = $('#return_amt');

        var paidVal = paidElement.val();
        var subTotalVal = subTotalElement.val();

        if (subTotalVal === '0.00') {
            alert('Mohon isi detail item yang akan dilakukan dalam transaksi ini terlebih dahulu!');
            paidElement.val(getPriceFormattedNumber(0, 2));
            return false;
        }

        var returnAmtVal = parseFloat(removeNumberFormat(paidVal)) - parseFloat(removeNumberFormat(subTotalVal));

        returnAmtElement.val(getPriceFormattedNumber(returnAmtVal, 2));
    });

    // default set 0
    if ($('#paid_amt').val() === '') {
        $('#paid_amt').val(getPriceFormattedNumber(0, 2));
    }

    if ($('#return_amt').val() === '') {
        $('#return_amt').val(getPriceFormattedNumber(0, 2));
    }
}

/**
 * validate invoice form
 */
function validateInvoiceForm(isProcess) {
    var valid = true;

    // validate invoice form
    // 1. invoice date cannot empty
    // 2. validate must exist at least 1 item
    // 3. each item detail
    // 4. validate cannot duplicated item detail
    // 6. validate return amount cannot be -

    var invoice_datetime = $('#invoice_datetime');

    if (invoice_datetime.val() === '') {
        alert('Tanggal transaksi wajib diisi');
        scrollTo(invoice_datetime);
        invoice_datetime.focus();
        return false;
    }

    var itemDetailRow = $('#tableInvoiceDetail tbody tr');

    if (itemDetailRow.length == 0) {
        alert('Tidak terdapat item yang akan dijual dalam transaksi!');
        $('#addInvoiceItem').click();
        return false;
    }

    var index = 1;
    var itdtValidArr = [];
    itemDetailRow.each(function() {
        var currentRow = $(this);
        var itdt_id = $(this).find('td:eq(1) select');
        var quantity = $(this).find('td:eq(2) input');

        if (itdt_id.val() === '') {
            alert('Item pada baris no. ' + index + ' harap dipilih dalam transaksi penjualan');
            scrollTo(itdt_id.next());
            itdt_id.next().addClass('chosen-container-active');
            valid = false;
            return false;
        } else if (itdtValidArr.includes(itdt_id.val())) {
            alert('Item pada baris no. ' + index + ' terjadi duplikat pemilihan dalam transaksi penjualan');
            scrollTo(itdt_id.next());
            itdt_id.next().addClass('chosen-container-active');
            valid = false;
            return false;
        }

        if (quantity.val() === '') {
            alert('Kuantiti Item pada baris no. ' + index + ' Harap diisi');
            scrollTo(quantity);
            quantity.focus();
            valid = false;
            return false;
        } else {
            // check current item quantity
            var quantityFloat = parseFloat(removeNumberFormat(quantity.val()));
            for (var i = 0; i < globalInvoiceItemDetailList.length; i++) {
                var g_itdt_id = globalInvoiceItemDetailList[i].itdt_id;
                var g_quantity = globalInvoiceItemDetailList[i].quantity;

                if (g_itdt_id == itdt_id.val()) {
                    if (quantityFloat > parseFloat(g_quantity)) {
                        alert('Kuantiti item yang dijual melebihi stock yang tersedia pada baris no. ' + index);
                        scrollTo(quantity);
                        quantity.focus();
                        valid = false;
                        return false;
                    }
                }
            }
        }

        var e_return_amt = $('#return_amt');
        var e_pay_amt = $('#paid_amt');
        var e_sub_total = $('#invoice_sub_total');
        if (e_pay_amt.val() !== '' && e_sub_total.val() !== '') {
            if ((parseFloat(removeNumberFormat(e_pay_amt.val())) < parseFloat(removeNumberFormat(e_sub_total.val()))) && isProcess) {
                alert('Pembayaran tidak boleh kurang dari total harga barang!');
                scrollTo(e_pay_amt);
                e_pay_amt.focus();
                valid = false;
                return false;
            } 
        }

        itdtValidArr.push(itdt_id.val());
        index++;
    });

    return valid;
}

/**
 * submit invoice form
 */
function submitInvoiceForm() {
    $('#btnInvoiceSave').click(function() {
        $('#txtIsProcess').val("false");
        if (validateInvoiceForm(false)) {
            $('#confirmModal').modal('show');
        }
    });
}

function proceedTransaction() {
    $('#btnInvoiceProcess').click(function() {
        $('#txtIsProcess').val("true");
        if (validateInvoiceForm(true)) {
            $('#confirmModal').modal('show');
        }
    });
}

/**
 * trigger print when finisih processing transaction
 */
function automateTriggerPrint() {
    var isAutomate = $('#triggerPrint');
    var txtNew = $('#txtNew');
    if (typeof isAutomate.val() !== 'undefined') {
        if (isAutomate.val() === 'YES') {
            var url = './generateReceipt/invoice/' + $('#invcPreviewId').val();
            if (txtNew.val() === 'NO') {
                url = './manage_invoice/generateReceipt/invoice/' + $('#invcPreviewId').val();
            } 
            
            fnOpenPopUpWindow('Transaction Receipt', url);
        }
    }
}