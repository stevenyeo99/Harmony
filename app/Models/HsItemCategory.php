<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusType;

class HsItemCategory extends BaseModel
{
    protected $table = 'hs_item_category';

    protected $primaryKey = 'itcg_id';

    protected $fillable = [
        'code', 'name', 'description', 'status'
    ];

    public function getItemCategory() {
        $listOfItemCategory = [];
        $rsItemCategory = $this::where('status', StatusType::ACTIVE)->get();
        foreach($rsItemCategory as $itemCategory) {
            $listOfItemCategory[$itemCategory->itcg_id] = $itemCategory->name;
        }
        return $listOfItemCategory;
    }

    public function hsItemCategoryLog() {
        return $this->hasMany('App\Models\HsItemCategoryLog');
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
                    'code.required' => 'Kode tidak boleh kosong.',
                    'code.max' => 'Kode maksimal 10 huruf atau angka.',
                    'code.unique' => 'Kode yang sama telah digunakan.',
                    'name.required' => 'Nama tidak boleh kosong.',
                    'name.max' => 'Nama maksimal 50 huruf atau angka.',
                    'description.required' => 'Deskripsi tidak boleh kosong.',
                    'description.max' => 'Deskripsi maksimal 200 huruf atau angka.',
                ];
            case 'success':
                switch ($keyTwo) {
                    case 'create':
                        return 'Telah membuat kategori item dengan sukses!';
                    case 'update':
                        return 'Telah memperbarui kategori item dengan sukses!';
                    case 'delete':
                        return 'Telah menghapus kategori item dengan sukses!';
                    default:
                        break;
                }
            case 'failDelete':
                return 'Kategori item ini tidak dapat dihapus karena telah dipakai dimodul lain.';
            default:
                break;
        }
    }

    public function rules(HsItemCategory $hsItemCategory) {
        if (isset($hsItemCategory->itcg_id)) {
            return [
                'code' => 'required|max:10|unique:hs_item_category,code,'.$hsItemCategory->itcg_id.',itcg_id',
                'name' => 'required|max:50',
                'description' => 'required|max:100',
            ];
        } else {
            return [
                'code' => 'required|max:10|unique:hs_item_category',
                'name' => 'required|max:50',
                'description' => 'required|max:100',
            ];
        }
    }
}
