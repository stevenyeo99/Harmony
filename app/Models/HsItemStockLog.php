<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsItemStockLog extends BaseModel
{
    protected $table = 'hs_item_stock_log';

    protected $primaryKey = 'itsk_id';

    protected $fillable = [
        'itdt_id', 'original_quantity', 'add_quantity', 'min_quantity', 'prdt_id',
        'ivdt_id', 'change_type', 'change_time', 'user_id', 'new_quantity'
    ];

    /**
     * item detail 1-n item stock log
     */
    public function hsItemDetail() {
        return $this->belongsTo('App\Models\HsItemDetail', 'itdt_id');
    }

    public function errors() {
        return $this->errors();
    }
}
