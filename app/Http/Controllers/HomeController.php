<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MasterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HsInvoice;
use Carbon\Carbon;
use App\Enums\StatusType;

class HomeController extends MasterController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get first card title value
        $title1 = $this->getTitle('home');

        $homeActive = "active";

        return view('home', compact('title1', 'homeActive'));
    }

    /**
     * getting the sell-buy view
     * latest 7 days
     */
    public function gettingJsonSellBuyView() {
        $arrayObj = [];
        for ($i = 0; $i < 7; $i++) {
            $currentDate = Carbon::parse(Carbon::now()->subDays($i))->format('yy-m-d');
            
            $result = HsInvoice::whereDate('invoice_datetime', '=', $currentDate)
                ->where('status', StatusType::ACTIVE)
                ->groupBy('invoice_datetime')
                ->orderBy('invoice_datetime', 'ASC')
                ->selectRaw('SUM(sub_total) AS sub_total')
                ->first();
            
            $hsInvoiceDetail = new HsInvoice();
            $hsInvoiceDetail->invoice_datetime = Carbon::now()->subDays($i);

            if (!isset($result)) {
                $hsInvoiceDetail->sub_total = 0;
            } else {
                $hsInvoiceDetail->sub_total = $result->sub_total;
            }

            $arrayObj[$i] = $hsInvoiceDetail;
        }

        foreach ($arrayObj as $object) {
            $object->invoice_datetime = Carbon::parse($object->invoice_datetime)->format('m/d/yy');
        }

        $arrayObj = array_reverse($arrayObj);
        
        return response()->json($arrayObj);
    }
}
