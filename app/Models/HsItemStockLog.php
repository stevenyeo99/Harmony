<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsItemStockLog extends BaseModel
{
    protected $table = 'hs_item_stock_log';

    protected $primaryKey = 'itsk_id';

    protected $fillable = [
        'itdt_id', 'original_quantity', 'add_quantity', 'min_quantity', 'prdt_id',
        'ivdt_id', 'change_type', 'change_time', 'user_id', 'new_quantity', 'description'
    ];

    /**
     * item detail 1-n item stock log
     */
    public function hsItemDetail() {
        return $this->belongsTo('App\Models\HsItemDetail', 'itdt_id');
    }

    public function errors() {
        return $this->errors;
    }

    public function messages(string $key) {
        switch ($key) {
            case 'validation':
                return [
                    'new_quantity.required' => 'Kuantiti baru tidak boleh kosong.',
                    'new_quantity.regex' => 'Kuantiti harus berupa format decimal.',
                    'description.required' => 'Deskripsi tidak boleh kosong.',
                    'description.max' => 'Deskripsi maksimal 100 huruf atau angka.',
                ];
            case 'success':
                return 'Telan mengatur kuantiti item dengan sukses!';
            default: 
                break;
        }
    }

    public function rules(HsItemStockLog $hsItemStockLog) {
        return [
            'new_quantity' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required|max:100',
        ];
    }
}
