<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsSupplier;
use App\Models\HsSupplierLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;

class HsSupplierController extends MasterController
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * manage supplier page
     */
    public function index() {
        $title = $this->getTitle('manage_supplier');

        $supplierActive = "active";

        $ddlStatus = StatusType::getStrings();

        return view('supplier.index', compact('title', 'supplierActive', 'ddlStatus'));
    }

    /**
     * display data on datatables
     */
    public function displayData(Request $request) {
        $rsSupplier = HsSupplier::orderBy('code', 'asc')
            ->select(['splr_id', 'code', 'name', 'email', 'status']);

        return DataTables::of($rsSupplier)
            ->addColumn('action', function($supplier) {
                $btn = "<a href='" . $this->getRoute('view', $supplier->splr_id) . "' class='btn btn-info btn-sm'>Lihat</a>";
                $btn .= " <a href='" . $this->getRoute('edit', $supplier->splr_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                $btn .= " <button class='btn btn-danger btn-sm' onclick='trigDeleteModalBtn(\"" . $this->getRoute("delete", $supplier->splr_id) . "\");'>Hapus</button>";
                
                return $btn;
            })
            ->editColumn('status', function($supplier) {
                $label = "<span class='badge badge-success'>" . $supplier->status . "</span>";

                if ($supplier->status == 'INACTIVE') {
                    $label = "<span class='badge badge-danger'>" . $supplier->status . "</span>";
                }

                return $label;
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status', $keyword);    
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * go to create supplier page
     */
    public function create() {
        $title = $this->getTitle("create_supplier");

        $supplierActive = "active";

        return view('supplier.create', compact('title', 'supplierActive'));
    }

    /**
     * insert new supplier
     */
    public function store(Request $request) {

    }

    /**
     * view supplier form
     */
    public function view($id) {

    }

    /**
     * show supplier edit form
     */
    public function edit($id) {

    }

    /**
     * update supplier
     */
    public function update(Request $request, $id) {

    }

    /**
     * update supplier status to be inactive
     */
    public function delete($id) {

    }

    /**
     * get route by prefix
     */
    public function getRoute($key, $id = null) {
        switch ($key) {
            case 'index':
                return route('manage.supplier');
            case 'create':
                return route('manage.supplier.create');
            case 'view':
                return route('manage.supplier.view');
            case 'edit':
                return route('manage.supplier.edit', $id);
            case 'delete':
                return route('manage.supplier.delete', $id);
            default:
                break;
        }
    }
}
