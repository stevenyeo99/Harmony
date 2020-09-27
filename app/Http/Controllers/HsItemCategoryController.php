<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsItemCategory;
use App\Models\HsItemCategoryLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;
use App\Enums\ActionType;

class HsItemCategoryController extends MasterController {

    public function construct() {
        $this->middleware('auth');
    }

    public function index() {
        $title = $this->getTitle('manage_item_category');

        $itemActive = "active";

        $itemCategoryActive = "active";

        $ddlStatus = StatusType::getStrings();

        return view('item.category.index', compact('title', 'itemActive', 'itemCategoryActive', 'ddlStatus'));
    }

    public function displayData(Request $request) {
        $rsItemCategory = HsItemCategory::select(['itcg_id', 'code', 'name', 'description', 'status']);

        return DataTables::of($rsItemCategory)
            ->addColumn('action', function($itemCategory) {
                $btn = "<a href='" . $this->getRoute('view', $itemCategory->itcg_id) . "' class='btn btn-info btn-sm'>Lihat</a>";
                $btn .= " <a href='" . $this->getRoute('edit', $itemCategory->itcg_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                if ($itemCategory->status == StatusType::ACTIVE) {
                    $btn .= " <button class='btn btn-danger btn-sm' onclick='trigDeleteModalBtn(\"" . $this->getRoute("delete", $itemCategory->itcg_id) . "\");'>Hapus</button>";
                }
                
                return $btn;
            })
            ->editColumn('status', function($itemCategory) {
                $label = "<span class='badge badge-success'>" . $itemCategory->status . "</span>";

                if ($itemCategory->status == 'INACTIVE') {
                    $label = "<span class='badge badge-danger'>" . $itemCategory->status . "</span>";
                }

                return $label;
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status', $keyword);    
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function generateCategoryCode() {
        $rsItemCategory = HsItemCategory::orderBy('code', 'desc')->first();
        if (isset($rsItemCategory)) {
            $itemCategoryCode = "CG" . str_pad(intval(substr($rsItemCategory->code, 2)) + 1, 8, "0", STR_PAD_LEFT);
        }  else {
            $itemCategoryCode = "CG00000001";
        }
        return $itemCategoryCode;
    }

    public function create() {
        $title = $this->getTitle("create_item_category");

        $itemActive = "active";

        $itemCategoryActive = "active";

        $code = $this->generateCategoryCode();

        return view('item.category.create', compact('title', 'itemActive', 'itemCategoryActive', 'code'));
    }

    public function store(Request $request) {
        $data = Input::all();

        $hsItemCategory = new HsItemCategory();

        if ($hsItemCategory->validate($hsItemCategory, $data, $hsItemCategory->messages('validation'))) {
            try {
                DB::beginTransaction();

                $hsItemCategory->code = $this->generateCategoryCode();
                $hsItemCategory->name = $data['name'];
                $hsItemCategory->description = $data['description'];
                $hsItemCategory->status = StatusType::ACTIVE;
                $hsItemCategory->save();

                $hsItemCategoryLog = new HsItemCategoryLog();
                $hsItemCategoryLog->itcg_id = $hsItemCategory->itcg_id;
                $hsItemCategoryLog->action = ActionType::STORE;
                $hsItemCategoryLog->user_id = auth()->user()->user_id;
                $hsItemCategoryLog->log_date_time = now();
                $hsItemCategoryLog->save();

                DB::commit();

                // db transaction success
                $this->setFlashMessage('success', $hsItemCategory->messages('success', 'create'));
                return redirect($this->getRoute('create'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('create'), $e);
            }
        } else {
            $errors = $hsItemCategory->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('create'), $errors);
        }
    }

    public function view($id) {
        $itemActive = "active";

        $itemCategoryActive = "active";

        $itemCategoryObj = HsItemCategory::find($id);

        $title = $this->getTitle('view_item_category');

        return view('item.category.view', compact('title', 'itemCategoryObj', 'itemActive', 'itemCategoryActive'));
    }

    public function edit($id) {
        $itemActive = "active";

        $itemCategoryActive = "active";

        $itemCategoryObj = HsItemCategory::find($id);

        $title = $this->getTitle('edit_item_category');

        return view('item.category.edit', compact('title', 'itemCategoryObj', 'itemActive', 'itemCategoryActive'));
    }

    public function update(Request $request, $id) {
        $data = Input::all();

        $hsItemCategory = HsItemCategory::find($id);

        $hsItemCategory->name = $data['name'];
        $hsItemCategory->description = $data['description'];
        $hsItemCategory->status = StatusType::ACTIVE;
        
        if ($hsItemCategory->validate($hsItemCategory, $data, $hsItemCategory->messages('validation'))) {
            try {
                DB::beginTransaction();

                $hsItemCategory->save();

                $hsItemCategoryLog = new HsItemCategoryLog();
                $hsItemCategoryLog->itcg_id = $hsItemCategory->itcg_id;
                $hsItemCategoryLog->action = ActionType::EDIT;
                $hsItemCategoryLog->user_id = auth()->user()->user_id;
                $hsItemCategoryLog->log_date_time = now();
                $hsItemCategoryLog->save();

                DB::commit();

                // db transaction success
                $this->setFlashMessage('success', $hsItemCategory->messages('success', 'update'));
                return redirect($this->getRoute('index'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('edit', $hsItemCategory->itcg_id), $e);
            }
        } else {
            // form validation error
            $errors = $hsItemCategory->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('edit', $hsItemCategory->itcg_id), $errors);
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();

            $hsItemCategory = HsItemCategory::find($id);
            $hsItemCategory->status = StatusType::INACTIVE;
            $hsItemCategory->save();

            $hsItemCategoryLog = new HsItemCategoryLog();
            $hsItemCategoryLog->itcg_id = $hsItemCategory->itcg_id;
            $hsItemCategoryLog->action = ActionType::TERMINATE;
            $hsItemCategoryLog->user_id = auth()->user()->user_id;
            $hsItemCategoryLog->log_date_time = now();
            $hsItemCategoryLog->save();

            DB::commit();
            
            $this->setFlashMessage('success', $hsItemCategory->messages('success', 'delete'));
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
                return route('manage.item.category');
            case 'create':
                return route('manage.item.category.create');
            case 'view':
                return route('manage.item.category.view', $id);
            case 'edit':
                return route('manage.item.category.edit', $id);
            case 'delete':
                return route('manage.item.category.delete', $id);
            default:
                break;
        }
    }
}