<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsPurchase extends BaseModel
{
    protected $table = 'hs_purchase';

    protected $primaryKey = 'prch_id';

    protected $fillable = ['splr_id', 'sub_total', 'purchase_datetime', 'po_no', 'status'];

    public function hsPurchaseDetail() {
        return $this->hasMany('App\Models\HsPurchaseDetail', 'prch_id');
    }

    public function hsSupplier() {
        return $this->belongsTo('App\Models\HsSupplier', 'splr_id');
    }

    public function hsPurchaseLog() {
        return $this->hasMany('App\Models\HsPurchaseLog', 'prch_id');
    }

    public function hsItemStockLog() {
        return $this->hasOne('App\Models\HsItemStockLog', 'prch_id', 'prch_id');
    }

    public function errors() {
        return $this->errors;
    }

    public function messages(string $key, string $keyTwo = null) {
        switch ($key) {
            case 'success':
                case 'create':
                    return 'Telah membuat pembelian dengan sukses!';
                case 'update':
                    return 'Telah memperbarui pembelian dengan sukses!';
                case 'delete';
                    return 'Telah menghapus pembelian dengan sukses!';
                case 'approve':
                    return 'Penjualan telah tersimpan dalam transaksi!';
                default:
                    break;
        }
    }
}
