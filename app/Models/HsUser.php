<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class HsUser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'phone', 'password', 'is_admin', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $table = 'hs_user';

    protected $primaryKey = "user_id";

    /**
     * user has many supplier log
     */
    public function hsSupplierLog() {
        return $this->hasMany('App\Models\HsSupplierLog');
    }

    /**
     * user has many item stock log
     */
    public function hsItemStockLog() {
        return $this->hasMany('App\Models\HsItemStockLog');
    }

    /**
     * user has many item detail log
     */
    public function hsItemDetailLog() {
        return $this->hasMany('App\Models\HsItemDetailLog');
    }

    /**
     * user has many purchase log
     */
    public function hsPurchaseLog() {
        return $this->hasMany('App\Models\HsPurchaseLog');
    }

    /**
     * user has many item category log
     */
    public function hsItemCategoryLog() {
        return $this->hasMany('App\Models\HsItemCategoryLog');
    }

    /**
     * user has many invoice log
     */
    public function hsInvoiceLog() {
        return $this->hasMany('App\Models\HsInvoiceLog');
    }

    /**
     * Validate data with optional messages
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
    * get error from hs_user
    */
    public function errors() {
        return $this->errors;
    }

    /**
     * hs_user module messages
     */
    public function messages(string $key, string $keyTwo = null) {
        switch ($key) {
            case 'validation':
                return [
                    'user_name.required' => 'User name tidak boleh kosong.',
                    'user_name.min' => 'User name minimal 5 huruf atau angka.',
                    'user_name.max' => 'User name maksimal 50 huruf atau angka.',
                    'user_name.unique' => 'User name yang sama telah digunakan.',
                    'email.required' => 'Email tidak boleh kosong.',
                    'email.email' => 'Email harus berupa format email.',
                    'email.max' => 'Email maksimal 50 huruf atau angka.',
                    'email.unique' => 'Email yang sama telah digunakan.',
                    'phone.required' => 'Contact tidak boleh kosong.',
                    'phone.min' => 'Contact minimal 12 huruf atau angka.',
                    'phone.max' => 'Contact maksimal 50 huruf atau angka.',
                    'password.required' => 'Password tidak boleh kosong.',
                    'password.max' => 'Password maksimal 50 huruf atau angka.',
                    'password.confirmed' => 'Harap konfimasi password yang diisi.',
                    'g-recaptcha-response.required' => 'Harap validasi Captcha yang tersedia.',
                ];
            case 'success':
                switch($keyTwo) {
                    case 'create';
                        return 'Telah membuat user dengan sukses!';
                    case 'update':
                        return 'Telah memperbarui user dengan sukses!';
                    case 'delete':
                        return 'Telah menghapus user dengan sukses!';
                    default:
                        break;
                }
            case 'failDelete':
                return 'User ini tidak dapat dihapus karena telah dipakai dimodul lain.';
            default:
                break;
        }
    }

    /**
     * hs_user transaction rules
     */
    public function rules(HsUser $hsUser) {
        if (isset($hsUser->user_id)) {
            return [
                'user_name' => 'required|min:5|max:50|unique:hs_user,user_name,'.$hsUser->user_id.',user_id',
                'email' => 'required|email|max:50|unique:hs_user,email,'.$hsUser->user_id.',user_id',
                'phone' => 'required|min:12|max:50',
                'password' => 'required|max:15|confirmed',
                'g-recaptcha-response' => 'required|captcha',
            ];
        } else {
            return [
                'user_name' => 'required|min:5|max:50|unique:hs_user',
                'email' => 'required|email|max:50|unique:hs_user',
                'phone' => 'required|min:12|max:50',
                'password' => 'required|max:15|confirmed',
            ];
        }
    }
}
