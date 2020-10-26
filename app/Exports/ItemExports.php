<?php

namespace App\Exports;

use App\Models\HsItemDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Enums\StatusType;

class ItemExports implements FromCollection {

    public function collection() {
        return HsItemDetail::where('status', StatusType::ACTIVE)
            ->get();
    }
}