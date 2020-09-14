<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsSupplierLog extends BaseModel
{
    protected $table = 'hs_supplier_log';

    protected $primaryKey = 'splg_id';

    protected $fillable = [
        'splr_id', 'action', 'user_id', 'log_date_time'
    ];

    public function hsSupplier() {
        return $this->belongsTo('App\Models\HsSupplier', 'splr_id');
    }
}
