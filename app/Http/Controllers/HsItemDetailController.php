<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HsItemDetail;
use App\Models\HsItemDetailLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Enums\StatusType;
use App\Enums\ActionType;

class HsItemDetailController extends MasterController {

    public function construct() {
        $this->middleware('auth');
    }

    public function index() {
        $title = $this->getTitle('manage_item');

        $itemActive = "active";

        $itemDetailActive = "active";

        $ddlStatus = StatusType::getStrings();

        return view('item.detail.index', compact('title', 'itemActive', 'itemDetailActive', 'ddlStatus'));
    }
}