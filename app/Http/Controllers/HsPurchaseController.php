<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsPurchase;
use App\Models\HsPurchaseDetail;
use App\Models\HsPurchaseLog;
use App\Models\HsItemDetail;
use App\Models\HsSupplier;
use App\Models\HsItemStockLog;
use App\Models\HsAverageItemPrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;
use App\Enums\ActionType;
use App\Enums\ChangeType;
use Carbon\Carbon;

class HsPurchaseController extends MasterController {
    
    public function construct() {
        $this->middleware('auth');
    }

    public function index() {
        $title = $this->getTitle('manage_purchase');

        $purchaseActive = "active";

        $supplierModel = new HsSupplier();
        $listOfSupplier = $supplierModel->getSupplier();

        $ddlStatus = StatusType::getStrings();

        return view('purchase.index', compact('title', 'purchaseActive', 'listOfSupplier', 'ddlStatus'));
    }

    public function displayData() {
        $rsPurchase = HsPurchase::join('hs_supplier', 'hs_supplier.splr_id', '=', 'hs_purchase.splr_id')
            ->select(['prch_id', 'po_no', 'hs_supplier.splr_id as splr_id', 'hs_supplier.name as supplier_name', 'sub_total', 'purchase_datetime', 'hs_purchase.status as status']);

        return DataTables::of($rsPurchase)
            ->addColumn('action', function($purchase) {
                $btn = "<a href='" . $this->getRoute('view', $purchase->prch_id) ."' class='btn btn-info btn-sm'>Lihat</a>";
                if ($purchase->status == StatusType::ACTIVE && !isset($purchase->po_no)) {
                    $btn .= " <a href='" . $this->getRoute('edit', $purchase->prch_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                    $btn .= " <button class='btn text-white btn-sm glowing-button' onclick='trigApproveModalBtn(\"" . $this->getRoute("approve", $purchase->prch_id) . "\");'>Terima</button>";
                    $btn .= " <button class='btn btn-danger btn-sm' onclick='trigDeleteModalBtn(\"" . $this->getRoute("delete", $purchase->prch_id) . "\");'>Hapus</button>";
                }
                
                return $btn;
            })
            ->editColumn('status', function($purchase) {
                $label = "<span class='badge badge-success'>" . $purchase->status . "</span>";

                if ($purchase->status == 'INACTIVE') {
                    $label = "<span class='badge badge-danger'>" . $purchase->status . "</span>";
                }

                return $label;
            })
            ->editColumn('splr_id', function($purchase) {
                return $purchase->supplier_name;
            })
            ->editColumn('sub_total', function($purchase) {
                    return number_format($purchase->sub_total, 2);
            })
            ->editColumn('purchase_datetime', function($purchase) {
                $date = Carbon::parse($purchase->purchase_datetime)->format('Y-m-d');
                return $date; 
            })
            ->filterColumn('splr_id', function($query, $keyword) {
                $query->where('hs_purchase.splr_id', $keyword);
            })
            ->filterColumn('purchase_datetime', function($query, $keyword) {
                if ($keyword) {
                    $query->whereDate('purchase_datetime', '=', $keyword);
                }
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('hs_purchase.status', $keyword);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * generate po number
     */
    public function generatePoNo() {
        $rsPurchase = HsPurchase::orderBy('po_no', 'desc')->first();

        if (isset($rsPurchase)) {
            $rsPurchase = "PO" . str_pad(intval(substr($rsPurchase->po_no, 2)) + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $rsPurchase = "PO00000001";
        }

        return $rsPurchase;
    }

    /**
     * get item by supplier
     */
    public function getSupplierItem($splr_id) {
        $hsItemDetail = new HsItemDetail();

        $hsItemDetailData = $hsItemDetail::where('splr_id', $splr_id)
            ->where('status', StatusType::ACTIVE)
            ->get();

        return response()->json($hsItemDetailData, 200);
    }

    /**
     * display create method
     */
    public function create() {
        $title = $this->getTitle("create_purchase");

        $purchaseActive = "active";

        $poNo = $this->generatePoNo();

        $supplierModel = new HsSupplier();
        $listOfSupplier = $supplierModel->getSupplier();

        return view('purchase.create', compact('title', 'purchaseActive', 'poNo', 'listOfSupplier'));
    }

    /**
     * store new purchase data
     */
    public function store(Request $request) {
        $data = Input::all();

        try {
            DB::beginTransaction();

            // initiate hs_purchase and store
            $hsPurchase = new HsPurchase();
            $hsPurchase->splr_id = $data['splr_id'];
            $hsPurchase->sub_total = str_replace(',', '', $data['sub_total']);
            $hsPurchase->purchase_datetime = $data['purchase_datetime'];
            $hsPurchase->status = StatusType::ACTIVE;
            $hsPurchase->save();

            // initiate hs_puchase item and store
            $itemDetailData = $data['itdt'];
            $hsPurchaseDetails = [];
            foreach ($itemDetailData as $itdt) {
                $hsPurchaseDetails[] = array(
                    'prch_id' => $hsPurchase->prch_id,
                    'itdt_id' => $itdt['itdt_id'],
                    'quantity' => str_replace(',', '', $itdt['quantity']),
                    'sub_total' => str_replace(',', '', $itdt['sub_total']),
                    'price' => str_replace(',', '', $itdt['price']),
                );
            }
            HsPurchaseDetail::insert($hsPurchaseDetails);

            // initiate hs_purchase_log
            $hsPurchaseLog = new HsPurchaseLog();
            $hsPurchaseLog->prch_id = $hsPurchase->prch_id;
            $hsPurchaseLog->action = ActionType::STORE;
            $hsPurchaseLog->user_id = auth()->user()->user_id;
            $hsPurchaseLog->log_date_time = now();
            $hsPurchaseLog->save();
            
            DB::commit();
            
            $this->setFlashMessage('success', $hsPurchase->messages('success', 'create'));
            return redirect($this->getRoute('create'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('create'), $e);
        }
    }

    public function view($id) {
        $title = $this->getTitle("view_purchase");

        $purchaseActive = "active";

        $poNo = $this->generatePoNo();

        $purchaseObj = HsPurchase::find($id);

        $supplierModel = new HsSupplier();
        $listOfSupplier = $supplierModel->getSupplier();

        return view('purchase.view', compact('title', 'purchaseActive', 'purchaseObj', 'poNo'));
    }

    public function edit($id) {
        $title = $this->getTitle("edit_purchase");

        $purchaseActive = "active";

        $poNo = $this->generatePoNo();

        $purchaseObj = HsPurchase::find($id);

        $supplierModel = new HsSupplier();
        $listOfSupplier = $supplierModel->getSupplier();

        $hsItemDetail = new HsItemDetail();

        $hsItemDetailData = $hsItemDetail::where('splr_id', $purchaseObj->splr_id)
            ->where('status', StatusType::ACTIVE)
            ->get();

        return view('purchase.edit', compact('title', 'purchaseActive', 'purchaseObj', 'poNo', 'listOfSupplier', 'hsItemDetailData'));
    }

    public function update(Request $request, $id) {
        $data = Input::all();

        try {
            DB::beginTransaction();

            // initiate hs_purchase and update
            $hsPurchase = HsPurchase::find($id);
            $hsPurchase->splr_id = $data['splr_id'];
            $hsPurchase->sub_total = str_replace(',', '', $data['sub_total']);
            $hsPurchase->purchase_datetime = $data['purchase_datetime'];
            $hsPurchase->status = StatusType::ACTIVE;
            $hsPurchase->save();

            // delete the previous purchase detail for easy logic and reinsert
            HsPurchaseDetail::where('prch_id', $hsPurchase->prch_id)->delete();
            $itemDetailData = $data['itdt'];
            $hsPurchaseDetails = [];
            foreach ($itemDetailData as $itdt) {
                $hsPurchaseDetails[] = array (
                    'prch_id' => $hsPurchase->prch_id,
                    'itdt_id' => $itdt['itdt_id'],
                    'quantity' => str_replace(',', '', $itdt['quantity']),
                    'sub_total' => str_replace(',', '', $itdt['sub_total']),
                    'price' => str_replace(',', '', $itdt['price']),
                );
            }
            HsPurchaseDetail::insert($hsPurchaseDetails);

            // initiate hs_purchase_log
            $hsPurchaseLog = new HsPurchaseLog();
            $hsPurchaseLog->prch_id = $hsPurchase->prch_id;
            $hsPurchaseLog->action = ActionType::EDIT;
            $hsPurchaseLog->user_id = auth()->user()->user_id;
            $hsPurchaseLog->log_date_time = now();
            $hsPurchaseLog->save();

            DB::commit();

            $this->setFlashMessage('success', $hsPurchase->messages('success', 'update'));
            return redirect($this->getRoute('index'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('edit', $id), $e);
        }
    }

    /**
     * approve purchase data: 
     */
    public function approve(Request $request, $id) {
        try {
            DB::beginTransaction();
            
            // 1. generate purchase no
            $hsPurchase = HsPurchase::find($id);
            $hsPurchase->po_no = $this->generatePoNo();
            $hsPurchase->save();

            // 2. add data into action log
            $hsPurchaseLog = new HsPurchaseLog();
            $hsPurchaseLog->prch_id = $hsPurchase->prch_id;
            $hsPurchaseLog->action = ActionType::EDIT;
            $hsPurchaseLog->user_id = auth()->user()->user_id;
            $hsPurchaseLog->log_date_time = now();
            $hsPurchaseLog->save();

            // 3. new data for item stock log
            $hsItemStockLogs = [];
            $hsPurchaseDetails = HsPurchaseDetail::where('prch_id', $hsPurchase->prch_id)->get();
            foreach ($hsPurchaseDetails as $hsPurchaseDetail) {
                
                // 4. average the item price rules
                // re-save and calculate the item price and net price
                $hsAverageItemPrice = new HsAverageItemPrice();
                $hsAverageItemPrice->itdt_id = $hsPurchaseDetail->itdt_id;
                $hsAverageItemPrice->quantity = $hsPurchaseDetail->quantity;
                $hsAverageItemPrice->price = $hsPurchaseDetail->price;
                $hsAverageItemPrice->total_price = $hsPurchaseDetail->sub_total;
                $hsAverageItemPrice->created_at = now();
                $hsAverageItemPrice->save();

                $rsAvg = HsAverageItemPrice::where('itdt_id', $hsAverageItemPrice->itdt_id)
                    ->selectRaw("sum(price) as sumPrice, count(*) as total")
                    ->first();
                $avgPrice = $rsAvg["sumPrice"] / $rsAvg["total"];

                $hsItemDetail = HsItemDetail::find($hsAverageItemPrice->itdt_id);
                $hsItemDetail->price = $avgPrice;
                $hsItemDetail->net_price = $avgPrice + ($avgPrice * ($hsItemDetail->net_pct / 100));
                $hsItemDetail->save(); 

                $originalQuantity = $hsPurchaseDetail->hsItemDetail->quantity;
                if (!isset($originalQuantity)) {
                    $originalQuantity = '0.00';
                }

                $hsItemStockLogs[] = array (
                    'itdt_id' => $hsPurchaseDetail->itdt_id,
                    'original_quantity' => $originalQuantity,
                    'add_quantity' => $hsPurchaseDetail->quantity,
                    'min_quantity' => '0.00',
                    'prdt_id' => $hsPurchaseDetail->prdt_id,
                    'ivdt_id' => null,
                    'change_type' => ChangeType::PURCHASE,
                    'change_time' => now(),
                    'user_id' => auth()->user()->user_id,
                    'new_quantity' => floatval($originalQuantity) + floatval($hsPurchaseDetail->quantity),
                    'description' => 'Transaksi pembelian item pada PO: ' . $hsPurchase->po_no,
                );
            }

            HsItemStockLog::insert($hsItemStockLogs);

            // 4. update item quantity
            foreach ($hsItemStockLogs as $item) {
                $hsItemDetail = HsItemDetail::find($item['itdt_id']);
                $hsItemDetail->quantity = $item['new_quantity'];
                $hsItemDetail->save();
            }

            DB::commit();

            $this->setFlashMessage('success', $hsPurchase->messages('success', 'approve'));
            return redirect($this->getRoute('index'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('index'), $e);
        }
    }

    public function delete(Request $request, $id) {
        try {
            DB::beginTransaction();
            
            $hsPurchase = HsPurchase::find($id);
            $hsPurchase->status = StatusType::INACTIVE;
            $hsPurchase->save();

            $hsPurchaseLog = new HsPurchaseLog();
            $hsPurchaseLog->prch_id = $hsPurchase->prch_id;
            $hsPurchaseLog->action = ActionType::TERMINATE;
            $hsPurchaseLog->user_id = auth()->user()->user_id;
            $hsPurchaseLog->log_date_time = now();
            $hsPurchaseLog->save();

            DB::commit();

            $this->setFlashMessage('success', $hsPurchase->messages('success', 'delete'));
            return redirect($this->getRoute('index'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('index'), $e);
        }
    }

    public function getRoute($key, $id = null) {
        switch ($key) {
            case 'index':
                return route('manage.purchase');
            case 'create':
                return route('manage.purchase.create');
            case 'view':
                return route('manage.purchase.view', $id);
            case 'edit':
                return route('manage.purchase.edit', $id);
            case 'approve':
                return route('manage.purchase.approve', $id);
            case 'delete':
                return route('manage.purchase.delete', $id);
            default:
                break;
        }
    }
}