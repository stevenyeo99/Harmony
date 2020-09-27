<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsItemDetail;
use App\Models\HsItemDetailLog;
use App\Models\HsItemStockLog;
use App\Models\HsItemCategory;
use App\Models\HsItemUom;
use App\Models\HsSupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;
use App\Enums\ActionType;
use App\Enums\ChangeType;

class HsItemDetailController extends MasterController {

    public function construct() {
        $this->middleware('auth');
    }

    /**
     * manage item page
     */
    public function index() {
        $title = $this->getTitle('manage_item_detail');

        $itemActive = "active";

        $itemDetailActive = "active";

        $ddlStatus = StatusType::getStrings();

        $itemCategoryModel = new HsItemCategory();

        $listOfItemCategory = $itemCategoryModel->getItemCategory();

        return view('item.detail.index', compact('title', 'itemActive', 'itemDetailActive', 'ddlStatus', 'listOfItemCategory'));
    }

    /**
     * display list of item details datatable
     */
    public function displayData() {
        $rsItemDetail = HsItemDetail::join('hs_item_category', 'hs_item_category.itcg_id', '=', 'hs_item_detail.itcg_id')
        ->select(['itdt_id', 'hs_item_detail.code', 'hs_item_detail.name', 'hs_item_detail.itcg_id', 'hs_item_category.name as category_name', 'hs_item_detail.status']);

        return DataTables::of($rsItemDetail)
            ->addColumn('action', function($itemDetail) {
                $btn = "<a href='" . $this->getRoute('view', $itemDetail->itdt_id) ."' class='btn btn-info btn-sm'>Lihat</a>";
                $btn .= " <a href='" . $this->getRoute('edit', $itemDetail->itdt_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                if ($itemDetail->status == StatusType::ACTIVE) {
                    $btn .= " <button class='btn btn-danger btn-sm' onclick='trigDeleteModalBtn(\"" . $this->getRoute("delete", $itemDetail->itdt_id) . "\");'>Hapus</button>";
                    $btn .= " <a href='" . $this->getRoute('stock', $itemDetail->itdt_id) . "' class='btn btn-success btn-sm'>Stock</a>";
                }
                
                return $btn;
            })
            ->editColumn('status', function($itemDetail) {
                $label = "<span class='badge badge-success'>" . $itemDetail->status . "</span>";

                if ($itemDetail->status == 'INACTIVE') {
                    $label = "<span class='badge badge-danger'>" . $itemDetail->status . "</span>";
                }

                return $label;
            })
            ->editColumn('itcg_id', function($itemDetail) {
                return $itemDetail->category_name;
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('hs_item_detail.status', $keyword);
            })
            ->filterColumn('itcg_id', function($query, $keyword) {
                $query->where('hs_item_detail.itcg_id', $keyword);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * generate item code
     */
    public function generateItemCode() {
        $rsItemCategory = HsItemDetail::orderBy('code', 'desc')->first();
        if (isset($rsItemCategory)) {
            $itemCategoryCode = "IT" . str_pad(intval(substr($rsItemCategory->code, 2)) + 1, 8, "0", STR_PAD_LEFT);
        }  else {
            $itemCategoryCode = "IT00000001";
        }
        return $itemCategoryCode;
    }

    /**
     * item detail creation page
     */
    public function create() {
        $title = $this->getTitle("create_item_detail");

        $itemActive = "active";

        $itemDetailActive = "active";

        $code = $this->generateItemCode();

        $itemCategoryModel = new HsItemCategory();
        $listOfItemCategory = $itemCategoryModel->getItemCategory();

        $supplierModel = new HsSupplier();
        $listOfSupplier = $supplierModel->getSupplier();

        $itemUomModel = new HsItemUom();
        $listOfItemUom = $itemUomModel->getItemUom();

        return view('item.detail.create', compact('title', 'itemActive', 'itemDetailActive', 'code', 'listOfItemCategory', 'listOfSupplier', 'listOfItemUom'));
    }

    /**
     * insert new item details
     */
    public function store(Request $request) {
        $data = Input::all();
        $data['price'] = str_replace(',', '', $data['price']);
        $data['quantity'] = str_replace(',', '', $data['quantity']);
        $data['net_pct'] = str_replace(',', '', $data['net_pct']);
        $data['net_price'] = str_replace(',', '', $data['net_price']);

        $hsItemDetail = new HsItemDetail();

        if ($hsItemDetail->validate($hsItemDetail, $data, $hsItemDetail->messages('validation'))) {
            try {
                DB::beginTransaction();

                // HS_ITEM_DETAIL
                $hsItemDetail->code = $this->generateItemCode();
                $hsItemDetail->name = $data['name'];
                $hsItemDetail->description = $data['description'];
                $hsItemDetail->price = $data['price'];
                $hsItemDetail->splr_id = $data['splr_id'];
                $hsItemDetail->itcg_id = $data['itcg_id'];
                $hsItemDetail->quantity = $data['quantity'];
                $hsItemDetail->created_at = now();
                $hsItemDetail->status = StatusType::ACTIVE;
                $hsItemDetail->ituo_id = $data['ituo_id'];
                $hsItemDetail->net_pct = $data['net_pct'];
                $hsItemDetail->net_price = $data['net_price'];
                $hsItemDetail->save();

                // HS_ITEM_DETAIL_LOG
                $hsItemDetailLog = new HsItemDetailLog();
                $hsItemDetailLog->itdt_id = $hsItemDetail->itdt_id;
                $hsItemDetailLog->action = ActionType::STORE;
                $hsItemDetailLog->user_id = auth()->user()->user_id;
                $hsItemDetailLog->log_date_time = now();
                $hsItemDetailLog->save();

                // HS_ITEM_STOCK_LOG
                $hsItemStockLog = new HsItemStockLog();
                $hsItemStockLog->itdt_id = $hsItemDetail->itdt_id;
                $hsItemStockLog->original_quantity = '0.00';
                $hsItemStockLog->add_quantity = $hsItemDetail->quantity;
                $hsItemStockLog->min_quantity = '0.00';
                $hsItemStockLog->change_type = ChangeType::NEWITEM;
                $hsItemStockLog->change_time = now();
                $hsItemStockLog->user_id = Auth()->user()->user_id;
                $hsItemStockLog->new_quantity = $hsItemDetail->quantity;
                $hsItemStockLog->description = "Buat Item Baru";
                $hsItemStockLog->save();

                DB::commit();

                $this->setFlashMessage('success', $hsItemDetail->messages('success', 'create'));
                return redirect($this->getRoute('create'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('create'), $e);
            }
        } else {
            $errors = $hsItemDetail->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('create'), $errors);
        }
    }

    /**
     * view item detail page
     */
    public function view($id) {
        $title = $this->getTitle("view_item_detail");

        $itemActive = "active";

        $itemDetailActive = "active";

        $itemDetailObj = HsItemDetail::find($id);

        $itemCategoryModel = new HsItemCategory();
        $listOfItemCategory = $itemCategoryModel->getItemCategory();

        $supplierModel = new HsSupplier();
        $listOfSupplier = $supplierModel->getSupplier();

        $itemUomModel = new HsItemUom();
        $listOfItemUom = $itemUomModel->getItemUom();

        return view('item.detail.view', compact('title', 'itemDetailObj', 'itemActive', 'itemDetailActive',
            'listOfItemCategory', 'listOfSupplier', 'listOfItemUom'));
    }

    /**
     * edit item detail page
     */
    public function edit($id) {
        $title = $this->getTitle("edit_item_detail");

        $itemActive = "active";

        $itemDetailActive = "active";

        $itemDetailObj = HsItemDetail::find($id);

        $itemCategoryModel = new HsItemCategory();
        $listOfItemCategory = $itemCategoryModel->getItemCategory();

        $supplierModel = new HsSupplier();
        $listOfSupplier = $supplierModel->getSupplier();

        $itemUomModel = new HsItemUom();
        $listOfItemUom = $itemUomModel->getItemUom();

        return view('item.detail.edit', compact('title', 'itemDetailObj', 'itemActive', 'itemDetailActive',
            'listOfItemCategory', 'listOfSupplier', 'listOfItemUom'));
    }

    /**
     * update item detail
     */
    public function update(Request $request, $id) {
        $data = Input::all();
        
        $data['price'] = str_replace(',', '', $data['price']);
        $data['net_pct'] = str_replace(',', '', $data['net_pct']);
        $data['net_price'] = str_replace(',', '', $data['net_price']);
        
        $hsItemDetail = HsItemDetail::find($id);
        $hsItemDetail->name = $data['name'];
        $hsItemDetail->description = $data['description'];
        $hsItemDetail->splr_id = $data['splr_id'];
        $hsItemDetail->itcg_id = $data['itcg_id'];
        $hsItemDetail->ituo_id = $data['ituo_id'];
        $hsItemDetail->price = str_replace(',', '', $data['price']);
        $hsItemDetail->net_pct = str_replace(',', '', $data['net_pct']);
        $hsItemDetail->net_price = str_replace(',', '', $data['net_price']);
        $hsItemDetail->status = StatusType::ACTIVE;
        $hsItemDetail->updated_at = now();
        
        if ($hsItemDetail->validate($hsItemDetail, $data, $hsItemDetail->messages('validation'))) {
            try {
                DB::beginTransaction();

                $hsItemDetail->save();

                $hsItemDetailLog = new HsItemDetailLog();
                $hsItemDetailLog->itdt_id = $hsItemDetail->itdt_id;
                $hsItemDetailLog->action = ActionType::EDIT;
                $hsItemDetailLog->user_id = auth()->user()->user_id;
                $hsItemDetailLog->log_date_time = now();
                $hsItemDetailLog->save();

                DB::commit();

                $this->setFlashMessage('success', $hsItemDetail->messages('success', 'update'));
                return redirect($this->getRoute('index'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('edit', $hsItemDetail->itdt_id), $e);
            }
        } else {
            $errors = $hsItemDetail->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('edit', $hsItemDetail->itdt_id), $errors);
        }
    }

    /**
     * delete item details (update the status to be inactive because prevent constraint key)
     */
    public function delete($id) {
        try {
            DB::beginTransaction();

            $hsItemDetail = HsItemDetail::find($id);
            $hsItemDetail->status = StatusType::INACTIVE;
            $hsItemDetail->updated_at = now();
            $hsItemDetail->save();

            $hsItemDetailLog = new HsItemDetailLog();
            $hsItemDetailLog->itdt_id = $hsItemDetail->itdt_id;
            $hsItemDetailLog->action = ActionType::TERMINATE;
            $hsItemDetailLog->user_id = auth()->user()->user_id;
            $hsItemDetailLog->log_date_time = now();
            $hsItemDetailLog->save();

            DB::commit();

            $this->setFlashMessage('success', $hsItemDetail->messages('success', 'delete'));
            return redirect($this->getRoute('index'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('index'), $e);
        }
    }

    /**
     * stock log page
     */
    public function viewStock($id) {
        $hsItemDetail = HsItemDetail::find($id);
        $itemStockName = '(' . $hsItemDetail->name . ' - [' . $hsItemDetail->code . '])';
        $title = $this->getTitle('manage_item_stock', $itemStockName);
        $itemActive = "active";

        $itemDetailActive = "active";
        $itemId = $id;
        return view('item.stock.index', compact('title', 'itemActive', 'itemDetailActive', 'itemId'));
    }

    /**
     * display list of stock transaction history
     */
    public function listStock($id) {
        $rsItemStock = HsItemStockLog::where('itdt_id', $id)
            ->from('hs_item_stock_log as stock')
            ->join('hs_user as user', 'user.user_id', '=', 'stock.user_id')
            ->orderBy('stock.change_time', 'desc')
            ->selectRaw('stock.original_quantity, stock.add_quantity, stock.min_quantity, stock.new_quantity, stock.change_type, 
                user.user_name, stock.change_time');

        return DataTables::of($rsItemStock)
            ->addColumn('before', function($itemStock) {
                return $itemStock->original_quantity;
            })
            ->addColumn('transaction', function($itemStock) {
                $spanQty = '<span class="text text-warning>0.00</span>';
                if ($itemStock->add_quantity != '0.00') {
                    $spanQty = '<span class="text text-success">+'.$itemStock->add_quantity.'</span>';
                } else if ($itemStock->min_quantity != '0.00') {
                    $spanQty = '<span class="text text-danger">+'.$itemStock->min_quantity.'</span>';
                } 
                return $spanQty;
            })
            ->addColumn('after', function($itemStock) {
                return $itemStock->new_quantity;
            })
            ->addColumn('type', function($itemStock) {
                return $itemStock->change_type;
            })
            ->addColumn('editBy', function($itemStock) {
                return $itemStock->user_name;
            })
            ->addColumn('log', function($itemStock) {
                return $itemStock->change_time;
            })
            ->rawColumns(['before', 'transaction', 'after', 'type', 'editBy', 'log'])
            ->make(true);
    } 

    /**
     * edit stock quantity
     */
    public function editStock($id) {

    }

    /**
     * update stock transaction by user manual
     */
    public function updateStock(Request $request, $id) {

    }

    public function getRoute($key, $id = null) {
        switch ($key) {
            case 'index':
                return route('manage.item.detail');
            case 'create':
                return route('manage.item.detail.create');
            case 'view':
                return route('manage.item.detail.view', $id);
            case 'edit':
                return route('manage.item.detail.edit', $id);
            case 'delete':
                return route('manage.item.detail.delete', $id);
            case 'stock':
                return route('manage.item.detail.viewStock', $id);
            case 'editStock':
                return route('manage.item.detail.editStock', $id);
            default:
                break;
        }
    }
}