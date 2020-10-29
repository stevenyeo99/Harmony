<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\HsItemDetail;
use App\Models\HsItemStockLog;
use App\Enums\StatusType;
use App\Enums\ChangeType;
use Illuminate\Support\Facades\Input;
use PDF;
use Carbon\Carbon;

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

        $transactionReportActive = "active";

        $transactionItemReportActive = "active";

        $title = $this->getTitle("report_transaction_item");

        $hsItemDetail = HsItemDetail::where('status', StatusType::ACTIVE)
            ->get();

        $ddlItemDetails = [];
        $ddlItemDetails[0] = "-- Semua Item --";
        foreach ($hsItemDetail as $item) {
            $ddlItemDetails[$item->itdt_id] = $item->name;
        }

        return view('report.item.index', compact('transactionReportActive', 'transactionItemReportActive', 'title', 'ddlItemDetails'));
    }

    /**
     * item transaction report export
     */
    public function generateItemTransactionReport(Request $request) {
        $data = Input::all();
        
        $itdt_id = $data['itdt_id'];
        $date_from = $data['date_from'];
        $date_to = $data['date_to'];

        set_time_limit(300);

        $listOfHsItemDetail = HsItemDetail::where('status', StatusType::ACTIVE)
            ->orderBy('code', 'asc')
            ->get();
        if ($itdt_id != 0) {
            $listOfHsItemDetail = HsItemDetail::where('status', StatusType::ACTIVE)
                ->where('itdt_id', $itdt_id)
                ->get();
        }

        // data each item log
        $dataExist = false;
        foreach ($listOfHsItemDetail as $hsItemDetail) {
            $listOfHsItemStockLogs = HsItemStockLog::whereDate('change_time', '>=', $date_from)
                ->whereDate('change_time', '<=', $date_to)
                ->where('itdt_id', $hsItemDetail->itdt_id)
                ->orderBy('change_time', 'asc')
                ->get();
            
            foreach ($listOfHsItemStockLogs as $itemStock) {
                if ($itemStock->min_quantity == '0.00') {
                    $itemStock->plusOrMinusQuantity = "PLUS";
                } else {
                    $itemStock->plusOrMinusQuantity = "MIN";
                }
                $dataExist = true;

                $itemStock->change_type = ChangeType::getTextChangeType($itemStock->change_type);
            }
            $hsItemDetail->listOfItemStockLogs = $listOfHsItemStockLogs;
        }

        $pdf = PDF::loadview('report.item.template', [
                'listOfHsItemDetail' => $listOfHsItemDetail, 'date_from' => $date_from, 'date_to' => $date_to, 'dataExist' => $dataExist
            ])->setPaper('A4', 'landscape');

        return $pdf->download(Carbon::parse(now())->format('yymd').'_transaksi_item.pdf');
    }

    /**
     * purchase report view
     */
    public function purchaseReportIndex() {
        $transactionReportActive = "active";

        $transactionPurchaseReportActive = "active";

        $title = $this->getTitle("report_transaction_purchase");
        
        return view('report.purchase.index', compact('transactionReportActive', 'transactionPurchaseReportActive', 'title'));
    }

    /**
     * purchase transaction report export
     */
    public function generatePurchaseTransactionReport(Request $request) {
        $data = Input::all();

        set_time_limit(300);

        $purchaseListObj = [];

        $pdf = PDF::loadview('report.purchase.template', ['purchaseListObj' => $purchaseListObj]);
        return $pdf->download('pembelian.pdf');
    }

    /**
     * invoice report view
     */
    public function invoiceReportIndex() {
        $transactionReportActive = "active";

        $transactionInvoiceReportActive = "active";

        $title = $this->getTitle("report_transaction_invoice");
        
        return view('report.purchase.index', compact('transactionReportActive', 'transactionInvoiceReportActive', 'title'));
    }

    /**
     * invoice transaction report export
     */
    public function generateInvoiceTransactionReport(Request $request) {
        $data = Input::all();

        set_time_limit(300);

        $invoiceListObj = [];

        $pdf = PDF::loadview('report.invoice.template', ['invoiceListObj' => $invoiceListObj]);
        return $pdf->download('penjualan.pdf');
    }
}