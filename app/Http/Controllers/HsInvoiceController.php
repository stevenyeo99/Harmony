<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsInvoice;
use App\Models\HsInvoiceDetail;
use App\Models\HsInvoiceLog;
use App\Models\HsItemStockLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;
use App\Enums\ActionType;
use App\Enums\ChangeType;
use Carbon\Carbon;

class HsInvoiceController extends MasterController {
 
    public function construct() {
        $this->middleware('auth');
    }

    public function index() {

    }

    public function displayData() {

    }

    public function generateInvNo() {
        $rsInvoice = HsInvoice::orderBy('invoice_no', 'desc')->first();

        if (isset($rsInvoice)) {
            $rsInvoice = "IV" . str_pad(intval(substr($rsInvoice->invoice_no, 2)) + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $rsInvoice = "IV00000001";
        }

        return $rsInvoice;
    }

    /**
     * create form
     */
    public function create() {
        
    }

    /**
     * insert data
     */
    public function store(Request $request) {

    }

    /**
     * view form
     */
    public function view($id) {

    }

    /**
     * edit form
     */
    public function edit($id) {

    }

    /**
     * update data
     */
    public function update(Request $request, $id) {

    }

    /**
     * approve data
     */
    public function approve(Request $request, $id) {

    }

    /**
     * delete data (inactive status)
     */
    public function delete(Request $request, $id) {

    }

    public function getRoute($key, $id = null) {
        switch ($key) {
            case 'index':
                return route('manage.invoice');
            case 'create':
                return route('manage.invoice.create');
            case 'view':
                return route('manage.invoice.view', $id);
            case 'edit':
                return route('manage.invoice.edit', $id);
            case 'approve':
                return route('manage.invoice.approve', $id);
            case 'delete':
                return route('manage.invoice.delete', $id);
            default:
                break;
        }
    }
}