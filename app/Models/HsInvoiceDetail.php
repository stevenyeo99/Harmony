<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsInvoiceDetail extends BaseModel
{
    protected $table = 'hs_invoice_detail';

    protected $primaryKey = 'ivdt_id';

    protected $fillable = [
        'invc_id', 'quantity', 'price', 'sub_total', 'itdt_id',
    ];

    public function hsInvoice() {
        return $this->belongsTo('App\Models\HsInvoice', 'invc_id');
    }

    public function hsItemDetail() {
        return $this->belongsTo('App\Models\HsItemDetail', 'itdt_id');
    }
}
