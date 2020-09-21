<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusType;

class HsItemUom extends BaseModel
{
    protected $table = 'hs_item_uom';

    protected $primaryKey = 'ituo_id';

    protected $fillable = [
        'name', 'description', 'status'
    ];

    public function getItemUom() {
        $listOfItemUom = [];
        $rsItemUom = $this::where('status', StatusType::ACTIVE)->get();
        foreach($rsItemUom as $itemUom) {
            $listOfItemUom[$itemUom->ituo_id] = $itemUom->name;
        }
        return $listOfItemUom;
    }

    public function hsItemUomLog() {
        return $this->hasMany('App\Models\HsItemUomLog');
    }

    public function hsItemDetail() {
        return $this->hasMany('App\Models\HsItemDetail');
    }

    public function errors() {
        return $this->errors;
    }

    public function messages(string $key, string $keyTwo = null) {
        switch ($key) {
            case 'validation':
                return [
                    'name.required' => 'Nama tidak boleh kosong.',
                    'name.max' => 'Nama maksimal 20 huruf atau angka.',
                    'name.unique' => 'Nama yang sama telah digunakan.',
                    'description.required' => 'Deskripsi tidak boleh kosong.',
                    'description.max' => 'Deskripsi maksimal 200 huruf atau angka.',
                ];
            case 'success':
                switch ($keyTwo) {
                    case 'create':
                        return 'Telah membuat jenis unit dengan sukses!';
                    case 'update':
                        return 'Telah memperbarui jenis unit dengan sukses!';
                    case 'delete':
                        return 'Telah menghapus jenis unit dengan sukses!';
                    default:
                        break;
                }
            case 'failDelete':
                return 'Jenis unit ini tidak dapat dihapus karena telah dipakai dimodul lain.';
            default:
                break;
        }
    }

    public function rules(HsItemUom $hsItemUom) {
        if (isset($hsItemUom->ituo_id)) {
            return [
                'name' => 'required|max:20|unique:hs_item_uom,name,'.$hsItemUom->ituo_id.',ituo_id',
                'description' => 'required|max:200',
            ];
        } else {
            return [
                'name' => 'required|max:20|unique:hs_item_uom',
                'description' => 'required|max:200',
            ];
        }
    }
}