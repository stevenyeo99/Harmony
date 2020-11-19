<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsSupplier;
use App\Models\HsSupplierLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;
use App\Enums\ActionType;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

        $count = count(HsSupplier::where('status', StatusType::ACTIVE)->get());

        return view('supplier.index', compact('title', 'supplierActive', 'ddlStatus', 'count'));
    }

    /**
     * display data on datatables
     */
    public function displayData(Request $request) {
        $rsSupplier = HsSupplier::select(['splr_id', 'code', 'name', 'email', 'status']);

        return DataTables::of($rsSupplier)
            ->addColumn('action', function($supplier) {
                $btn = "<a href='" . $this->getRoute('view', $supplier->splr_id) . "' class='btn btn-info btn-sm'>Lihat</a>";
                $btn .= " <a href='" . $this->getRoute('edit', $supplier->splr_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                if ($supplier->status == StatusType::ACTIVE) {
                    $btn .= " <button class='btn btn-danger btn-sm' onclick='trigDeleteModalBtn(\"" . $this->getRoute("delete", $supplier->splr_id) . "\");'>Hapus</button>";
                }
                
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

        if ($hsSupplier->validate($hsSupplier, $data, $hsSupplier->messages('validation'))) {
            try {
                DB::beginTransaction();

                $hsSupplier->save();

                $hsSupplierLog = new HsSupplierLog();
                $hsSupplierLog->splr_id = $hsSupplier->splr_id;
                $hsSupplierLog->action = ActionType::STORE;
                $hsSupplierLog->user_id = auth()->user()->user_id;
                $hsSupplierLog->log_date_time = now();
                $hsSupplierLog->save();

                DB::commit();

                // db transaction success
                $this->setFlashMessage('success', $hsSupplier->messages('success', 'create'));
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
        $supplierModel = new HsSupplier();

        $supplierObj = $supplierModel::find($id);

        $supplierActive = "active";

        $title = $this->getTitle('view_supplier');

        return view('supplier.view', compact('title', 'supplierObj', 'supplierActive'));
    }

    /**
     * show supplier edit form
     */
    public function edit($id) {
        $supplierObj = HsSupplier::find($id);

        $title = $this->getTitle('edit_supplier');

        $supplierActive = "active";

        return view('supplier.edit', compact('title', 'supplierObj', 'supplierActive'));
    }

    /**
     * update supplier
     */
    public function update(Request $request, $id) {
        $data = Input::all();

        $hsSupplier = HsSupplier::find($id);

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

        if ($hsSupplier->validate($hsSupplier, $data, $hsSupplier->messages('validation'))) {
            try {
                DB::beginTransaction();

                $hsSupplier->save();

                $hsSupplierLog = new HsSupplierLog();
                $hsSupplierLog->splr_id = $hsSupplier->splr_id;
                $hsSupplierLog->action = ActionType::EDIT;
                $hsSupplierLog->user_id = auth()->user()->user_id;
                $hsSupplierLog->log_date_time = now();
                $hsSupplierLog->save();

                DB::commit();

                // db transaction success
                $this->setFlashMessage('success', $hsSupplier->messages('success', 'update'));
                return redirect($this->getRoute('index'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('edit', $hsSupplier->splr_id), $e);
            }
        } else {
            // form validation error
            $errors = $hsSupplier->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('edit', $hsSupplier->splr_id), $errors);
        }
    }

    /**
     * update supplier status to be inactive
     */
    public function delete($id) {
        try {
            DB::beginTransaction();

            $hsSupplier = HsSupplier::find($id);
            $hsSupplier->status = StatusType::INACTIVE;
            $hsSupplier->save();

            $hsSupplierLog = new HsSupplierLog();
            $hsSupplierLog->splr_id = $hsSupplier->splr_id;
            $hsSupplierLog->action = ActionType::TERMINATE;
            $hsSupplierLog->user_id = auth()->user()->user_id;
            $hsSupplierLog->log_date_time = now();
            $hsSupplierLog->save();

            DB::commit();
            
            $this->setFlashMessage('success', $hsSupplier->messages('success', 'delete'));
            return redirect($this->getRoute('index'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('index'), $e);
        }
    }

    public function exportSupplierReport() {
        setLocale(LC_TIME, 'id-ID');

        $result = HsSupplier::where('status', StatusType::ACTIVE)
            ->get();

        $result_array = array();

        $count = count($result);

        if ($count > 0) {
            foreach ($result as $key => $res) {
                $result_array[$key]['Kode'] = $res->code;
                $result_array[$key]['Nama'] = $res->name;
                $result_array[$key]['email'] = $res->email;
                $result_array[$key]['Alamat'] = $res->address_line_1;
                if (isset($res->address_line_2)) {
                    $result_array[$key]['Alamat'] .= ' ' . $res->address_line_2;
                }
                if (isset($res->address_line_3)) {
                    $result_array[$key]['Alamat'] .= ' ' . $res->address_line_3;
                }
                if (isset($res->address_line_4)) {
                    $result_array[$key]['Alamat'] .= ' ' . $res->address_line_4;
                }
                $result_array[$key]['Nomor Telpon'] = $res->telp_no;
                $result_array[$key]['Kontak Nama 1'] = $res->contact_name_1;
                $result_array[$key]['Kontak No 1'] = $res->contact_person_1;
                $result_array[$key]['Kontak Nama 2'] = $res->contact_name_2;
                $result_array[$key]['Kontak No 2'] = $res->contact_person_2;
                $result_array[$key]['Kontak Nama 3'] = $res->contact_name_3;
                $result_array[$key]['Kontak No 3'] = $res->contact_person_3;
                $result_array[$key]['Kontak Nama 4'] = $res->contact_name_4;
                $result_array[$key]['Kontak No 4'] = $res->contact_person_4;
            }

            Excel::create('Data Supplier Harmony', function($excel) use ($result_array, $count) {

                $excel->sheet('Data Supplier', function($sheet) use ($result_array, $count) {
                    
                    // Fill the XLS with data
                    $sheet->fromArray($result_array, null, 'A1', true);

                    // set Row height
                    $sheet->setHeight(1, 25);

                    // Manipulate Row
                    $sheet->row(1, function ($row) {
                        $row->setFontWeight('bold');
                        $row->setAlignment('center');
                        $row->setValignment('center');
                    });

                    $fromToBorder = 'A1:M'.($count+1);

                    $sheet->cell('A2:A' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('B2:B' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('C2:C' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('D2:D' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('E2:E' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('F2:F' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('G2:G' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('H2:H' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('I2:I' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('J2:J' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('K2:K' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('L2:L' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    $sheet->cell('M2:M' . ($count + 1), function($cell) {
                        $cell->setAlignment('center');
                    });

                    // Freeze first row
                    // $sheet->freezeFirstRow();

                    $styleArray = array(
                        'borders' => array(
                            'allborders' => array(
                            'style' => 'thin'
                            )
                        )
                    );

                    $sheet->getStyle($fromToBorder)->applyFromArray($styleArray);
                });
            })->export('xlsx');
        }
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
                return route('manage.supplier.view', $id);
            case 'edit':
                return route('manage.supplier.edit', $id);
            case 'delete':
                return route('manage.supplier.delete', $id);
            default:
                break;
        }
    }
}
