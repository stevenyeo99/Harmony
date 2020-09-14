<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsItemDetailLog extends BaseModel
{
    protected $table = 'hs_item_detail_log';

    protected $primaryKey = 'itdl_id';

    protected $fillable = [
        'itdt_id', 'action', 'user_id', 'log_date_time'
    ];
}
