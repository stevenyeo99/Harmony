<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/aw', function() {
// 	return Hash::make('suzybae8');
// });
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routing
// disabled register route
Auth::routes(['register' => false]);

// prevent error while run logout url
Route::get('/logout', function() {
    return back();
});

// user profile routing

// manage user module
Route::prefix('/manage_user')->group(function() {
    Route::get('/profile', 'HsUserController@getProfile')->name('manage.user.profile');
    Route::post('/save_profile', 'HsUserController@saveProfile')->name('manage.user.save_profile');

    // manage admin route
    Route::group(['middleware' => 'can:is-admin'], function() {
        Route::get('/', 'HsUserController@index')->name('manage.user');
        Route::get('/list', 'HsUserController@displayData')->name('manage.user.list');
        Route::get('/create', 'HsUserController@create')->name('manage.user.create');
        Route::post('/create', 'HsUserController@store')->name('manage.user.store');
        Route::get('/view/{id}', 'HsUserController@view')->name('manage.user.view');
        Route::get('/edit/{id}', 'HsUserController@edit')->name('manage.user.edit');
        Route::post('/update/{id}', 'HsUserController@update')->name('manage.user.update');
        Route::post('/delete/{id}', 'HsUserController@delete')->name('manage.user.delete');
    });
});

// manage supplier module
Route::prefix('/manage_supplier')->group(function() {
    Route::get('/', 'HsSupplierController@index')->name('manage.supplier');
    Route::get('/list', 'HsSupplierController@displayData')->name('manage.supplier.list');
    Route::get('/create', 'HsSupplierController@create')->name('manage.supplier.create');
    Route::post('/create', 'HsSupplierController@store')->name('manage.supplier.store');
    Route::get('/view/{id}', 'HsSupplierController@view')->name('manage.supplier.view');
    Route::get('/edit/{id}', 'HsSupplierController@edit')->name('manage.supplier.edit');
    Route::post('/update/{id}', 'HsSupplierController@update')->name('manage.supplier.update');
    Route::post('/delete/{id}', 'HsSupplierController@delete')->name('manage.supplier.delete');
    // export excel
    Route::get('/exportSupplierData', 'HsSupplierController@exportSupplierReport')->name('manage.supplier.exportSupplierReport');
});

// manage item detail module
Route::prefix('/manage_item_detail')->group(function() {
    Route::get('/', 'HsItemDetailController@index')->name('manage.item.detail');
    Route::get('/list', 'HsItemDetailController@displayData')->name('manage.item.detail.list');
    Route::get('/create', 'HsItemDetailController@create')->name('manage.item.detail.create');
    Route::post('/create', 'HsItemDetailController@store')->name('manage.item.detail.store');
    Route::get('/view/{id}', 'HsItemDetailController@view')->name('manage.item.detail.view');
    Route::get('/edit/{id}', 'HsItemDetailController@edit')->name('manage.item.detail.edit');
    Route::post('/update/{id}', 'HsItemDetailController@update')->name('manage.item.detail.update');
    Route::post('/delete/{id}', 'HsItemDetailController@delete')->name('manage.item.detail.delete');
    Route::get('/stock/{id}', 'HsItemDetailController@viewStock')->name('manage.item.detail.viewStock');
    Route::get('/listStock/{id}', 'HsItemDetailController@listStock')->name('manage.item.detail.listStock');
    Route::get('/editStock/{id}', 'HsItemDetailController@editStock')->name('manage.item.detail.editStock');
    Route::post('/updateStock/{id}', 'HsItemDetailController@updateStock')->name('manage.item.detail.updateStock');
    // export excel
    Route::get('/exportItemData', 'HsItemDetailController@exportItemReport')->name('manage.item.detail.exportItemReport');
});

// manage item category module
Route::prefix('/manage_item_category')->group(function() {
    Route::get('/', 'HsItemCategoryController@index')->name('manage.item.category');
    Route::get('/list', 'HsItemCategoryController@displayData')->name('manage.item.category.list');
    Route::get('/create', 'HsItemCategoryController@create')->name('manage.item.category.create');
    Route::post('/create', 'HsItemCategoryController@store')->name('manage.item.category.store');
    Route::get('/view/{id}', 'HsItemCategoryController@view')->name('manage.item.category.view');
    Route::get('/edit/{id}', 'HsItemCategoryController@edit')->name('manage.item.category.edit');
    Route::post('/update/{id}', 'HsItemCategoryController@update')->name('manage.item.category.update');
    Route::post('/delete/{id}', 'HsItemCategoryController@delete')->name('manage.item.category.delete');
});

// manage item unit module
Route::prefix('/manage_item_unit')->group(function() {
    Route::get('/', 'HsItemUnitController@index')->name('manage.item.unit');
    Route::get('/list', 'HsItemUnitController@displayData')->name('manage.item.unit.list');
    Route::get('/create', 'HsItemUnitController@create')->name('manage.item.unit.create');
    Route::post('/create', 'HsItemUnitController@store')->name('manage.item.unit.store');
    Route::get('/view/{id}', 'HsItemUnitController@view')->name('manage.item.unit.view');
    Route::get('/edit/{id}', 'HsItemUnitController@edit')->name('manage.item.unit.edit');
    Route::post('/update/{id}', 'HsItemUnitController@update')->name('manage.item.unit.update');
    Route::post('/delete/{id}', 'HsItemUnitController@delete')->name('manage.item.unit.delete');
});

// manage purchase module
Route::prefix('/manage_purchase')->group(function() {
    Route::get('/', 'HsPurchaseController@index')->name('manage.purchase');
    Route::get('/list', 'HsPurchaseController@displayData')->name('manage.purchase.list');
    Route::get('/create', 'HsPurchaseController@create')->name('manage.purchase.create');
    Route::post('/create', 'HsPurchaseController@store')->name('manage.purchase.store');
    Route::get('/view/{id}', 'HsPurchaseController@view')->name('manage.purchase.view');
    Route::get('/edit/{id}', 'HsPurchaseController@edit')->name('manage.purchase.edit');
    Route::post('/update/{id}', 'HsPurchaseController@update')->name('manage.purchase.update');
    Route::post('/approve/{id}', 'HsPurchaseController@approve')->name('manage.purchase.approve');
    Route::post('/delete/{id}', 'HsPurchaseController@delete')->name('manage.purchase.delete');
    
    // ajax request component form
    Route::get('/ajax/supplier_item/{splr_id}', 'HsPurchaseController@getSupplierItem')->name('manage.purchase.getSupplierItem');
});

// manage invoice module
Route::prefix('/manage_invoice')->group(function() {
    Route::get('/', 'HsInvoiceController@index')->name('manage.invoice');
    Route::get('/list', 'HsInvoiceController@displayData')->name('manage.invoice.list');
    Route::get('/create', 'HsInvoiceController@create')->name('manage.invoice.create');
    Route::post('/create', 'HsInvoiceController@store')->name('manage.invoice.store');
    Route::get('/view/{id}', 'HsInvoiceController@view')->name('manage.invoice.view');
    Route::get('/edit/{id}', 'HsInvoiceController@edit')->name('manage.invoice.edit');
    Route::post('/update/{id}', 'HsInvoiceController@update')->name('manage.invoice.update');
    Route::post('/approve/{id}', 'HsInvoiceController@approve')->name('manage.invoice.approve');
    Route::post('/delete/{id}', 'HsInvoiceController@delete')->name('manage.invoice.delete');

    // ajax request component form
    Route::get('/ajax/invoice_item', 'HsInvoiceController@getInvoiceItems')->name('manage.invoice.getInvoiceItems');

    // print transaction struct
    Route::get('/receipt/invoice/{id}', 'HsInvoiceController@receiptPage')->name('manage.invoice.receiptPage');
    Route::get('/generateReceipt/invoice/{id}', 'HsInvoiceController@generateReceipt')->name('manage.invoice.generateReceipt');
});

// manage harmony report
Route::prefix('/manage_report')->group(function() {
    // data transaction item
    Route::get('/transaction/item', 'HsReportController@itemReportIndex')->name('manage.report.itemReportIndex');
    // Route::get('/transaction/item/view', 'HsReport')
    Route::post('/transaction/export/item', 'HsReportController@generateItemTransactionReport')->name('manage.report.generateItemTransactionReport');

    // data transaction purchase
    Route::get('/transaction/purchase', 'HsReportController@purchaseReportIndex')->name('manage.report.purchaseReportIndex');
    Route::post('/transaction/export/purchase', 'HsReportController@generatePurchaseTransactionReport')->name('manage.report.generatePurchaseTransactionReport');

    // data transaction invoice
    Route::get('/transaction/invoice', 'HsReportController@invoiceReportIndex')->name('manage.report.invoiceReportIndex');
    Route::post('/transaction/export/invoice', 'HsReportController@generateInvoiceTransactionReport')->name('manage.report.generateInvoiceTransactionReport');
});

// home routing
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gettingJsonSellBuyView', 'HomeController@gettingJsonSellBuyView')->name('line_chart_json');