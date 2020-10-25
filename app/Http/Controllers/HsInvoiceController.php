<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsInvoice;
use App\Models\HsInvoiceDetail;
use App\Models\HsInvoiceLog;
use App\Models\HsItemDetail;
use App\Models\HsItemStockLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;
use App\Enums\ActionType;
use App\Enums\ChangeType;
use Carbon\Carbon;
use PDF;

class HsInvoiceController extends MasterController {
 
    public function construct() {
        $this->middleware('auth');
    }

    public function index() {
        $invoiceActive = "active";

        $title = $this->getTitle('manage_invoice');

        $ddlStatus = StatusType::getStrings();

        return view('invoice.index', compact('invoiceActive', 'title', 'ddlStatus'));
    }

    public function displayData() {
        $rsInvoice = HsInvoice::select(['invc_id', 'invoice_no', 'sub_total', 'invoice_datetime', 'status']);

        return DataTables::of($rsInvoice)
            ->addColumn('action', function($invoice) {
                $btn = "<a href='" . $this->getRoute('view', $invoice->invc_id) ."' class='btn btn-info btn-sm'>Lihat</a>";
                if ($invoice->status == StatusType::ACTIVE && !isset($invoice->invoice_no)) {
                    $btn .= " <a href='" . $this->getRoute('edit', $invoice->invc_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                    // $btn .= " <button class='btn text-white btn-sm glowing-button' onclick='trigApproveModalBtn(\"" . $this->getRoute("approve", $invoice->invc_id) . "\");'>Terima</button>";
                    $btn .= " <button class='btn btn-danger btn-sm' onclick='trigDeleteModalBtn(\"" . $this->getRoute("delete", $invoice->invc_id) . "\");'>Hapus</button>";
                }
                
                return $btn;
            })
            ->editColumn('status', function($invoice) {
                $label = "<span class='badge badge-success'>" . $invoice->status . "</span>";

                if ($invoice->status == 'INACTIVE') {
                    $label = "<span class='badge badge-danger'>" . $invoice->status . "</span>";
                }

                return $label;
            })
            ->editColumn('sub_total', function($invoice) {
                    return number_format($invoice->sub_total, 2);
            })
            ->editColumn('invoice_datetime', function($invoice) {
                $date = Carbon::parse($invoice->invoice_datetime)->format('Y-m-d');
                return $date;
            })
            ->filterColumn('invoice_datetime', function($query, $keyword) {
                if ($keyword) {
                    $query->whereDate('invoice_datetime', '=', $keyword);
                }
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status', $keyword);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
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
     * get invoice data by ajax request
     */
    public function getInvoiceItems() {
        $hsItemDetailData = HsItemDetail::where('status', StatusType::ACTIVE)
            ->orderBy('code', 'desc')
            ->get();

        return response()->json($hsItemDetailData, 200);
    }

    /**
     * create form
     */
    public function create() {
        $title = $this->getTitle('create_invoice');

        $invoiceActive = "active";

        $invoiceNo = $this->generateInvNo();

        return view('invoice.create', compact('title', 'invoiceNo', 'invoiceActive'));
    }

    /**
     * insert data
     */
    public function store(Request $request) {
        $data = Input::all();

        $isProcessing = $data['txtIsProcess'];

        try {
            DB::beginTransaction();

            // initiate hs_invoice and store
            $hsInvoice = new HsInvoice();
            $hsInvoice->sub_total = str_replace(',', '', $data['sub_total']);
            $hsInvoice->invoice_datetime = $data['invoice_datetime'];
            $hsInvoice->status = StatusType::ACTIVE;
            $hsInvoice->paid_amt = str_replace(',', '', $data['paid_amt']);
            $hsInvoice->return_amt = str_replace(',', '', $data['return_amt']);
            $hsInvoice->save();

            // initiate hs_invoice_detail and store
            $itemDetailData = $data['itdt'];
            $hsInvoiceDetails = [];
            foreach ($itemDetailData as $itdt) {
                $hsInvoiceDetails[] = array (
                    'invc_id' => $hsInvoice->invc_id,
                    'quantity' => str_replace(',', '', $itdt['quantity']),
                    'price' => str_replace(',', '', $itdt['price']),
                    'sub_total' => str_replace(',', '', $itdt['sub_total']),
                    'itdt_id' => $itdt['itdt_id'],
                );
            }
            HsInvoiceDetail::insert($hsInvoiceDetails);

            // initiate hs_invoice_log
            $hsInvoiceLog = new HsInvoiceLog();
            $hsInvoiceLog->invc_id = $hsInvoice->invc_id;
            $hsInvoiceLog->action = ActionType::STORE;
            $hsInvoiceLog->user_id = auth()->user()->user_id;
            $hsInvoiceLog->log_date_time = now();
            $hsInvoiceLog->save();

            $triggerPrint = 'NO';
            $invcPreviewId = null;
            $new = null;
            
            // save transaction process
            if ($isProcessing == 'true') {
                $this->processingTransaction($hsInvoice);
                $triggerPrint = 'YES';
                $invcPreviewId = $hsInvoice->invc_id;
                $new = "YES";
            }

            DB::commit();

            $this->setFlashMessage('success', $hsInvoice->messages('success', 'create'));
            
            return redirect($this->getRoute('create'))
                ->with(['triggerPrint' => $triggerPrint, 'invcPreviewId' => $invcPreviewId, 'new' => $new]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('create'), $e);
        }
    }

    /**
     * processing invoice
     */
    public function processingTransaction(HsInvoice $hsInvoice) {
        
        if (!isset($hsInvoice->invoice_no)) {
            $hsInvoice->invoice_no = $this->generateInvNo();
            $hsInvoice->save();
        }

        // transaction for hs_item_stock_log
        $hsItemStockLogs = [];
        $hsInvoiceDetails = HsInvoiceDetail::where('invc_id', $hsInvoice->invc_id)->get();
        foreach ($hsInvoiceDetails as $hsInvoiceDetail) {
            $originalQuantity = $hsInvoiceDetail->hsItemDetail->quantity;

            if (!isset($originalQuantity)) {
                $originalQuantity = '0.00';
            }

            $hsItemStockLogs[] = array (
                'itdt_id' => $hsInvoiceDetail->itdt_id,
                'original_quantity' => $originalQuantity,
                'add_quantity' => '0.00',
                'min_quantity' => $hsInvoiceDetail->quantity,
                'prdt_id' => null,
                'ivdt_id' => $hsInvoiceDetail->ivdt_id,
                'change_type' => ChangeType::SALES,
                'change_time' => now(),
                'user_id' => auth()->user()->user_id,
                'new_quantity' => number_format(floatval($originalQuantity) - floatval($hsInvoiceDetail->quantity), 2),
                'description' => 'Transaksi penjualan item pada IV: ' . $hsInvoice->invoice_no,
            );
        }

        HsItemStockLog::insert($hsItemStockLogs);

        // update item quantity
        foreach ($hsItemStockLogs as $item) {
            $hsItemDetail = HsItemDetail::find($item['itdt_id']);
            $hsItemDetail->quantity = $item['new_quantity'];
            $hsItemDetail->save();
        }
    }

    /**
     * view form
     */
    public function view($id) {
        $title = $this->getTitle("view_invoice");

        $invoiceActive = "active";

        $invoiceNo = $this->generateInvNo();

        $invoiceObj = HsInvoice::find($id);

        $triggerPrint = null;

        return view('invoice.view', compact('title', 'invoiceActive', 'invoiceNo', 'invoiceObj', 'triggerPrint'));
    }

    /**
     * edit form
     */
    public function edit($id) {
        $title = $this->getTitle("edit_invoice");

        $invoiceActive = "active";

        $invoiceNo = $this->generateInvNo();

        $invoiceObj = HsInvoice::find($id);

        $hsItemDetailData = HsItemDetail::where('status', StatusType::ACTIVE)
            ->get();

        return view('invoice.edit', compact('title', 'invoiceActive', 'invoiceNo', 'invoiceObj', 'hsItemDetailData'));
    }

    /**
     * update data
     */
    public function update(Request $request, $id) {
        $data = Input::all();

        $isProcessing = $data['txtIsProcess'];

        try {
            DB::beginTransaction();

            // initiate hs_invoice and update
            $hsInvoice = HsInvoice::find($id);
            $hsInvoice->sub_total = str_replace(',', '', $data['sub_total']);
            $hsInvoice->invoice_datetime = $data['invoice_datetime'];
            $hsInvoice->status = StatusType::ACTIVE;
            $hsInvoice->paid_amt = str_replace(',', '', $data['paid_amt']);
            $hsInvoice->return_amt = str_replace(',', '', $data['return_amt']);
            $hsInvoice->save();

            // delete and reinsert
            HsInvoiceDetail::where('invc_id', $hsInvoice->invc_id)->delete();
            $itemDetailData = $data['itdt'];
            $hsInvoiceDetails = [];
            foreach ($itemDetailData as $itdt) {
                $hsInvoiceDetails[] = array (
                    'invc_id' => $hsInvoice->invc_id,
                    'quantity' => str_replace(',', '', $itdt['quantity']),
                    'price' => str_replace(',', '', $itdt['price']),
                    'sub_total' => str_replace(',', '', $itdt['sub_total']),
                    'itdt_id' => $itdt['itdt_id'],
                );
            }
            HsInvoiceDetail::insert($hsInvoiceDetails);

            // initiate hs_purchase_log
            $hsInvoiceLog = new HsInvoiceLog();
            $hsInvoiceLog->invc_id = $hsInvoice->invc_id;
            $hsInvoiceLog->action = ActionType::EDIT;
            $hsInvoiceLog->user_id = auth()->user()->user_id;
            $hsInvoiceLog->log_date_time = now();
            $hsInvoiceLog->save();

            $triggerPrint = 'NO';
            $invcPreviewId = null;
            $new = null;
            
            // save transaction process
            if ($isProcessing == 'true') {
                $this->processingTransaction($hsInvoice);
                $triggerPrint = 'YES';
                $invcPreviewId = $hsInvoice->invc_id;
                $new = "NO";
            }

            DB::commit();
            
            $this->setFlashMessage('success', $hsInvoice->messages('success', 'update'));
            return redirect($this->getRoute('index'))
                ->with(['triggerPrint' => $triggerPrint, 'invcPreviewId' => $invcPreviewId, 'new' => $new]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('edit', $id), $e);
        }
    }

    /**
     * delete data (inactive status)
     */
    public function delete(Request $request, $id) {
        try {
            DB::beginTransaction();
            
            $hsInvoice = HsInvoice::find($id);
            $hsInvoice->status = StatusType::INACTIVE;
            $hsInvoice->save();

            $hsInvoiceLog = new HsInvoiceLog();
            $hsInvoiceLog->invc_id = $hsInvoice->invc_id;
            $hsInvoiceLog->action = ActionType::TERMINATE;
            $hsInvoiceLog->user_id = auth()->user()->user_id;
            $hsInvoiceLog->log_date_time = now();
            $hsInvoiceLog->save();

            DB::commit();

            $this->setFlashMessage('success', $hsInvoice->messages('success', 'delete'));
            return redirect($this->getRoute('index'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('index'), $e);
        }
    }

    /**
     * receipt page for developer purpose
     */
    public function receiptPage($id) {
        $invoiceObj = HsInvoice::find($id);

        return view('invoice.receipt', compact('invoiceObj'));
    }

    /**
     * generate receipt
     */
    public function generateReceipt($id) {
        $invoiceObj = HsInvoice::find($id);

        set_time_limit(300);
        
        $pdf = PDF::loadview('invoice.receipt', ['invoiceObj' => $invoiceObj])
        ->setPaper(array(0,0,204,350), 'portrait');
        return $pdf->stream('file.pdf');
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
            case 'delete':
                return route('manage.invoice.delete', $id);
            default:
                break;
        }
    }
}