<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsAverageItemPrice extends BaseModel {

    protected $table = 'hs_average_item_price';

    protected $primaryKey = 'avgi_id';

    protected $fillable = [
        'itdt_id', 'quantity', 'price',
        'total_price'
    ];

    public function hsItemDetail() {
        return $this->belongsTo('App\Models\HsItemDetail', 'itdt_id');
    }
}