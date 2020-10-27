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

        $itemReportActive = "active";

        $title = $this->getTitle("report_item");

        return view('report.item.index', compact('itemReportActive', 'title'));
    }

    
}