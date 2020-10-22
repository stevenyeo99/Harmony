<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsItemDetail extends BaseModel
{
    protected $table = 'hs_item_detail';

    protected $primaryKey = 'itdt_id';

    protected $fillable = [
        'code', 'name', 'description', 'price', 'splr_id', 'itcg_id', 'quantity', 'created_at', 'updated_at', 'status', 'ituo_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ]; 

    public $timestamps = false;

    public function hsPurchaseDetail() {
        return $this->hasMany('App\Models\HsItemDetail', 'itdt_id');
    }

    public function hsItemDetailLog() {
        return $this->hasMany('App\Models\HsItemDetailLog');
    }

    public function errors() {
        return $this->errors;
    }

    public function messages(string $key, string $keyTwo = null) {
        switch ($key) {
            case 'validation':
                return [
                    'code.required' => 'Kode tidak boleh kosong.',
                    'code.max' => 'Kode maksimal 10 huruf atau angka.',
                    'code.unique' => 'Kode yang sama telah digunakan.',
                    'name.required' => 'Nama tidak boleh kosong.',
                    'name.max' => 'Nama maksimal 50 huruf atau angka.',
                    'description.required' => 'Deskripsi tidak boleh kosong.',
                    'description.max' => 'Deskripsi maksimal 100 huruf atau angka.',
                    'price.required' => 'Harga beli item tidak boleh kosong.',
                    'price.regex' => 'Harga beli item harus berupa format decimal.',
                    'splr_id.required' => 'Supplier tidak boleh kosong.',
                    'itcg_id.required' => 'Kategori tidak boleh kosong.',
                    'quantity.required' => 'Kuantiti item tidak boleh kosong.',
                    'quantity.regex' => 'Kuantiti item harus berupa format decimal.',
                    'ituo_id.required' => 'Unit tidak boleh kosong.',
                    'net_pct.required' => 'Persentasi keuntungan item tidak boleh kosong.',
                    'net_pct.regex' => 'Persentasi keuntungan item harus berupa format decimal.',
                    'net_price.required' => 'Harga jual item tidak boleh kosong.',
                    'net_price.regex' => 'Harga jual item harus berupa format decimal.',
                ];
            case 'success':
                switch ($keyTwo) {
                    case 'create':
                        return 'Telah membuat item baru dengan sukses!';
                    case 'update':
                        return 'Telah memperbarui item dengan sukses!';
                    case 'delete':
                        return 'Telah menghapus item dengan sukses!';
                    default:
                        break;
                }
            case 'failDelete':
                return 'Item detail ini tidak dapat dihapus karena telah dipakai ditempat lain';
            default:
                break;
        }
    }

    public function rules(HsItemDetail $hsItemDetail) {
        if (isset($hsItemDetail->itdt_id)) {
            return [
                'code' => 'required|max:10|unique:hs_item_detail,code,'.$hsItemDetail->itdt_id.',itdt_id',
                'name' => 'required|max:100',
                'description' => 'required|max:100',
                'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'splr_id' => 'required',
                'itcg_id' => 'required',
                'quantity' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'ituo_id' => 'required',
                'net_pct' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'net_price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
            ];
        } else {
            return [
                'code' => 'required|max:10|unique:hs_item_detail',
                'name' => 'required|max:100',
                'description' => 'required|max:100',
                'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'splr_id' => 'required',
                'itcg_id' => 'required',
                'quantity' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'ituo_id' => 'required',
                'net_pct' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'net_price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
            ];
        }
    }
}
