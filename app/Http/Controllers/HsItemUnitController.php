<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsItemUom;
use App\Models\HsItemUomLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;
use App\Enums\ActionType;

class HsItemUnitController extends MasterController {

    public function construct() {
        $this->middleware('auth');
    }

    public function index() {
        $title = $this->getTitle('manage_item_uom');

        $itemActive = "active";

        $itemUnitActive = "active";

        $ddlStatus = StatusType::getStrings();

        return view('item.unit.index', compact('title', 'itemActive', 'itemUnitActive', 'ddlStatus'));
    }

    public function displayData(Request $request) {
        $rsItemUnit = HsItemUom::select(['ituo_id', 'name', 'description', 'status']);

        return DataTables::of($rsItemUnit)
            ->addColumn('action', function($itemUnit) {
                $btn = "<a href='" . $this->getRoute('view', $itemUnit->ituo_id) . "' class='btn btn-info btn-sm'>Lihat</a>";
                $btn .= " <a href='" . $this->getRoute('edit', $itemUnit->ituo_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                if ($itemUnit->status == StatusType::ACTIVE) {
                    $btn .= " <button class='btn btn-danger btn-sm' onclick='trigDeleteModalBtn(\"" . $this->getRoute("delete", $itemUnit->ituo_id) . "\");'>Hapus</button>";
                }
                
                return $btn;
            })
            ->editColumn('status', function($itemUnit) {
                $label = "<span class='badge badge-success'>" . $itemUnit->status . "</span>";

                if ($itemUnit->status == 'INACTIVE') {
                    $label = "<span class='badge badge-danger'>" . $itemUnit->status . "</span>";
                }

                return $label;
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status', $keyword);    
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function create() {
        $title = $this->getTitle("create_item_uom");

        $itemActive = "active";

        $itemUnitActive = "active";

        return view('item.unit.create', compact('title', 'itemActive', 'itemUnitActive'));
    }

    public function store(Request $request) {
        $data = Input::all();

        $hsItemUom = new HsItemUom();

        if ($hsItemUom->validate($hsItemUom, $data, $hsItemUom->messages('validation'))) {
            try {
                DB::beginTransaction();

                $hsItemUom->name = $data['name'];
                $hsItemUom->description = $data['description'];
                $hsItemUom->status = StatusType::ACTIVE;
                $hsItemUom->save();

                $hsItemUomLog = new HsItemUomLog();
                $hsItemUomLog->ituo_id = $hsItemUom->ituo_id;
                $hsItemUomLog->action = ActionType::STORE;
                $hsItemUomLog->user_id = auth()->user()->user_id;
                $hsItemUomLog->log_date_time = now();
                $hsItemUomLog->save();

                DB::commit();

                // db transaction success
                $this->setFlashMessage('success', $hsItemUom->messages('success', 'create'));
                return redirect($this->getRoute('create'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('create'), $e);
            }
        } else {
            $errors = $hsItemUom->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('create'), $errors);
        }
    }

    public function view($id) {
        $itemActive = "active";

        $itemUnitActive = "active";

        $itemUomObj = HsItemUom::find($id);

        $title = $this->getTitle('view_item_uom');

        return view('item.unit.view', compact('title', 'itemUomObj', 'itemActive', 'itemUnitActive'));
    }

    public function edit($id) {
        $itemActive = "active";

        $itemUnitActive = "active";

        $itemUomObj = HsItemUom::find($id);

        $title = $this->getTitle('edit_item_uom');

        return view('item.unit.edit', compact('title', 'itemUomObj', 'itemActive', 'itemUnitActive'));
    }

    public function update(Request $request, $id) {
        $data = Input::all();

        $hsItemUom = HsItemUom::find($id);

        $hsItemUom->name = $data['name'];
        $hsItemUom->description = $data['description'];
        $hsItemUom->status = StatusType::ACTIVE;
        
        if ($hsItemUom->validate($hsItemUom, $data, $hsItemUom->messages('validation'))) {
            try {
                DB::beginTransaction();

                $hsItemUom->save();

                $hsItemUomLog = new HsItemUomLog();
                $hsItemUomLog->ituo_id = $hsItemUom->ituo_id;
                $hsItemUomLog->action = ActionType::EDIT;
                $hsItemUomLog->user_id = auth()->user()->user_id;
                $hsItemUomLog->log_date_time = now();
                $hsItemUomLog->save();

                DB::commit();

                // db transaction success
                $this->setFlashMessage('success', $hsItemUom->messages('success', 'update'));
                return redirect($this->getRoute('index'));
            } catch (\Exception $e) {
                 DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('edit', $hsItemUom->ituo_id), $e);
            }
        } else {
            // form validation error
            $errors = $hsItemUom->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('edit', $hsItemUom->ituo_id), $errors);
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();

            $hsItemUom = HsItemUom::find($id);
            $hsItemUom->status = StatusType::INACTIVE;
            $hsItemUom->save();

            $hsItemUomLog = new HsItemUomLog();
            $hsItemUomLog->ituo_id = $hsItemUom->ituo_id;
            $hsItemUomLog->action = ActionType::TERMINATE;
            $hsItemUomLog->user_id = auth()->user()->user_id;
            $hsItemUomLog->log_date_time = now();
            $hsItemUomLog->save();

            DB::commit();
            
            $this->setFlashMessage('success', $hsItemUom->messages('success', 'delete'));
            return redirect($this->getRoute('index'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('index'), $e);
        }
    }

    /**
     * get route by prefix
     */
    public function getRoute($key, $id = null) {
        switch ($key) {
            case 'index':
                return route('manage.item.unit');
            case 'create':
                return route('manage.item.unit.create');
            case 'view':
                return route('manage.item.unit.view', $id);
            case 'edit':
                return route('manage.item.unit.edit', $id);
            case 'delete':
                return route('manage.item.unit.delete', $id);
            default:
                break;
        }
    }
}