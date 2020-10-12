<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsPurchase extends BaseModel
{
    protected $table = 'hs_purchase';

    protected $primaryKey = 'prch_id';

    protected $fillable = ['splr_id', 'sub_total', 'purchase_datetime', 'po_no', 'status'];

    public function hsPurchaseDetail() {
        return $this->hasMany('App\Models\HsPurchaseDetail');
    }

    public function hsPurchaseLog() {
        return $this->hasMany('App\Models\HsPurchaseLog');
    }

    public function hsItemStockLog() {
        return $this->hasOne('App\Models\HsItemStockLog', 'prch_id', 'prch_id');
    }

    public function errors() {
        return $this->errors;
    }
}
