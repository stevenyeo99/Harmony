<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsInvoice extends BaseModel
{
    protected $table = 'hs_invoice';

    protected $primaryKey = 'invc_id';

    protected $fillable = ['sub_total', 'invoice_datetime', 'invoice_no', 'status', 'paid_amt', 'return_amt'];

    public function hsInvoiceDetail() {
        return $this->hasMany('App\Models\HsInvoiceDetail', 'invc_id');
    }

    public function hsInvoiceLog() {
        return $this->hasMany('App\Models\HsInvoiceLog', 'invc_id');
    }

    public function errors() {
        return $this->errors;
    }

    public function messages(string $key, string $keyTwo = null) {
        switch ($key) {
            case 'success':
                switch ($keyTwo) {
                    case 'create':
                        return 'Telah membuat transaksi penjualan dengan sukses!';
                    case 'update':
                        return 'Telah memperbarui transaksi penjualan dengan sukses!';
                    case 'delete';
                        return 'Telah menghapus transaksi penjualan dengan sukses!';
                    case 'approve':
                        return 'Transaksi penjualan telah diproses!';
                }
            default:
                break;
        }
    }
}
