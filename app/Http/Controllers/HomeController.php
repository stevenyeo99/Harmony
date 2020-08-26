<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MasterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HsInvoice as invoice;
use App\Models\HsPurchase as purchase;

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

        // get diagram card title value
        $title2 = $this->getTitle('diagram');

        

        return view('home', compact('title1', 'title2'));
    }

    /**
     * getting the sell-buy view
     * latest 7 days
     */
    public function gettingJsonSellBuyView() {

    }
}
