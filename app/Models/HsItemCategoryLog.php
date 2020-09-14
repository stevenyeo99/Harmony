<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsItemCategoryLog extends BaseModel
{
    protected $table = 'hs_item_category_log';

    protected $primaryKey = 'itcl_id';

    protected $fillable = [
        'itcg_id', 'action', 'user_id', 'log_date_time'
    ];

    public function hsItemCategory() {
        return $this->belongsTo('App\Models\HsItemCategory', 'itcg_id');
    }

    public function hsUser() {
        return $this->belongsTo('App\Models\HsUser', 'user_id');
    }
}
