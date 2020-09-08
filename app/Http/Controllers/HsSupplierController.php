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

    public function generateSupplierCode() {
        $rsSupplier = HsSupplier::orderBy('code', 'desc')->first();
        if (isset($rsSupplier)) {
            $supplierCode = "SP" . str_pad(intval(substr($rsSupplier->code, 2)) + 1, 8, "0", STR_PAD_LEFT);
        }  else {
            $supplierCode = "SP00000001";
        }
        return $supplierCode;
    }


    /**
     * go to create supplier page
     */
    public function create() {
        $title = $this->getTitle("create_supplier");

        $supplierActive = "active";

        // generate supplier kode
        $code = $this->generateSupplierCode();

        return view('supplier.create', compact('title', 'supplierActive', 'code'));
    }

    /**
     * insert new supplier
     */
    public function store(Request $request) {
        $data = Input::all();

        $hsSupplier = new HsSupplier();

        if ($hsSupplier->validate($hsSupplier, $data, $hsSupplier->messages('validation'))) {
            try {
                DB::beginTransaction();

                $hsSupplier->code = $this->generateSupplierCode();
                $hsSupplier->name = $data['name'];
                $hsSupplier->email = $data['email'];
                $hsSupplier->telp_no = $data['telp_no'];
                $hsSupplier->contact_name_1 = $data['contact_name_1'];
                $hsSupplier->contact_person_1 = $data['contact_person_1'];
                $hsSupplier->contact_name_2 = $data['contact_name_2'];
                $hsSupplier->contact_person_2 = $data['contact_person_2'];
                $hsSupplier->contact_name_3 = $data['contact_name_3'];
                $hsSupplier->contact_person_3 = $data['contact_person_3'];
                $hsSupplier->address_line_1 = $data['address_line_1'];
                $hsSupplier->address_line_2 = $data['address_line_2'];
                $hsSupplier->address_line_3 = $data['address_line_3'];
                $hsSupplier->address_line_4 = $data['address_line_4'];
                $hsSupplier->status = StatusType::ACTIVE;

                $hsSupplier->save();

                $hsSupplierLog = new HsSupplierLog();
                $hsSupplierLog->splr_id = $hsSupplier->splr_id;
                $hsSupplierLog->user_id = auth()->user()->user_id;
                $hsSupplierLog->log_date_time = now();
                $hsSupplierLog->save();

                DB::commit();

                // db transaction success
                $this->setFlashMessage('success', $hsUser->messages('success', 'create'));
                return redirect($this->getRoute('create'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('create'), $e);
            }
        } else {
            // form validation error
            $errors = $hsSupplier->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('create'), $errors);
        }
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
