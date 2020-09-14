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
        $title = $this->getTitle('manage_item_unit');

        $itemActive = "active";

        $itemUnitActive = "active";

        $ddlStatus = StatusType::getStrings();

        return view('item.unit.index', compact('title', 'itemActive', 'itemUnitActive', 'ddlStatus'));
    }

    public function create() {

    }

    public function store(Request $request) {

    }

    public function view($id) {

    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {

    }

    public function delete($id) {

    }
}