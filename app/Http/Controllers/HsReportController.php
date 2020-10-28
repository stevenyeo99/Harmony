<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Exports\ItemExports;

class HsReportController extends MasterController {

    public function construct() {
        $this->middleware('auth');
    }

    // laporan excel
    // 1. data item
    // 2. data supplier
    // 3. transaksi item
    // 4. transaksi pembelian
    // 5. transaksi penjualan

    /**
     * item report view
     */
    public function itemReportIndex() {

        $transactionItemReportActive = "active";

        $title = $this->getTitle("report_transaction_item");

        return view('report.item.index', compact('transactionItemReportActive', 'title'));
    }

    /**
     * item transaction report export
     */
    public function generateItemTransactionReport(Request $request) {

    }

    /**
     * purchase report view
     */
    public function purchaseReportIndex() {
        $transactionPurchaseReportActive = "active";

        $title = $this->getTitle("report_transaction_purchase");
        
    }

    /**
     * purchase transaction report export
     */
    public function generatePurchaseTransactionReport(Request $request) {

    }

    /**
     * invoice report view
     */
    public function invoiceReportIndex() {
        $transactionInvoiceReportActive = "active";

        $title = $this->getTitle("report_transaction_purchase");
    }

    /**
     * invoice transaction report export
     */
    public function generateInvoiceTransactionReport(Request $request) {

    }
}