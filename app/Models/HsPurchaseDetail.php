<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsPurchaseDetail extends BaseModel
{
    protected $table = 'hs_purchase_detail';

    protected $primaryKey = 'prdt_id';

    protected $fillable = [
        'prch_id', 'itdt_id', 'quantity', 'sub_total', 'price',
    ];
    
    public function hsPurchase() {
        return $this->belongsTo('App\Models\HsPurchase', 'prch_id');
    }

    public function hsItemDetail() {
        return $this->belongsTo('App\Models\HsItemDetail', 'itdt_id');
    }
}
