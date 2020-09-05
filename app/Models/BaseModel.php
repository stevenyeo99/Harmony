<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class BaseModel extends Model {

    // disabled auto fill timestamp field
    public $timestamps = false;

    /**
     * Validate data with optional custom messages.
     */
    public function validate($model, array $data, array $customMessage = []) {
        $validator = Validator::make($data, $this->rules($model), $customMessage);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }

        return true;
    }

    /**
     * Get the errors from model validation.
     */
    public function errors() {
        return $this->errors;
    }
}