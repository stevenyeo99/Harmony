<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsItemDetail;
use App\Models\HsItemDetailLog;
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

    public function getItemUom() {
        return HsItemUom::where('status', StatusType::ACTIVE)->get();
    }

    public function index() {
        $title = $this->getTitle('manage_item_detail');

        $itemActive = "active";

        $itemDetailActive = "active";

        $ddlStatus = StatusType::getStrings();

        $itemCategoryModel = new HsItemCategory();

        $listOfItemCategory = $itemCategoryModel->getItemCategory();

        return view('item.detail.index', compact('title', 'itemActive', 'itemDetailActive', 'ddlStatus', 'listOfItemCategory'));
    }

    public function displayData() {
        $rsItemDetail = HsItemDetail::select(['itdt_id', 'code', 'name', 'itcg_id', 'status']);

        return DataTables::of($rsItemDetail)
            ->addColumn('action', function($itemDetail) {
                $btn = "<a href='" . $this->getRoute('view', $itemDetail->itdt_id) ."' class='btn btn-info btn-sm'>Lihat</a>";
                $btn .= " <a href='" . $this->getRoute('edit', $itemDetail->itdt_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                if ($itemDetail->status == StatusType::ACTIVE) {
                    $btn .= " <button class='btn btn-danger btn-sm' onclick='trigDeleteModalBtn(\"" . $this->getRoute("delete", $itemDetail->itdt_id) . "\");'>Hapus</button>";
                }

                return $btn;
            })
            ->editColumn('status', function($itemDetail) {
                $label = "<span class='badge badge-success'>" . $itemDetail->status . "</span>";

                if ($itemUnit->status == 'INACTIVE') {
                    $label = "<span class='badge badge-danger'>" . $itemDetail->status . "</span>";
                }

                return $label;
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status', $keyword);
            })
            ->filterColumn('itcg_id', function($query, $keyword) {
                $query->where('itcg_id', $keyword);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function generateItemCode() {
        $rsItemCategory = HsItemDetail::orderBy('code', 'desc')->first();
        if (isset($rsItemCategory)) {
            $itemCategoryCode = "IT" . str_pad(intval(substr($rsItemCategory->code, 2)) + 1, 8, "0", STR_PAD_LEFT);
        }  else {
            $itemCategoryCode = "IT00000001";
        }
        return $itemCategoryCode;
    }

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
}