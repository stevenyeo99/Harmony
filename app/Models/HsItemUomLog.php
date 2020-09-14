<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsItemUomLog extends BaseModel
{
    protected $table = 'hs_item_uom_log';

    protected $primaryKey = 'itul_id';

    protected $fillable = [
        'ituo_id', 'action', 'user_id', 'log_date_time'
    ];

    public function hsItemUom() {
        return $this->belongsTo('App\Models\HsItemUom', 'ituo_id');
    }

    public function hsUser() {
        return $this->belongsTo('App\Models\HsUser', 'user_id');
    }
}