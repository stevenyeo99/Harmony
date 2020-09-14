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
}
