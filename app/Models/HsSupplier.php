<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsSupplier extends BaseModel
{
    protected $table = 'hs_supplier';

    protected $primaryKey = 'splr_id';

    protected $fillable = [
        'code', 'name', 'address_line_1', 'address_line_2', 'address_line_3', 'address_line_4',
        'telp_no', 'contact_person_1', 'contact_person_2', 'contact_person_3', 'status',
        'contact_name_1', 'contact_name_2', 'contact_name_3'
    ];

    /**
     * supplier 1-n supplier log
     */
    public function hsSupplierLog() {
        return $this->hasMany('App\Models\HsSupplierLog');
    }

    /**
     * error from hs_supplier
     */
    public function errors() {
        return $this->errors;
    }

    /**
     * hs_supplier module message
     */
    public function messages(string $key, string $keyTwo = null) {
        switch ($key) {
            case 'validation':
                return [
                    'code.required' => 'Kode Supplier tidak boleh kosong.',
                    'code.unique' => 'Kode Supplier yang sama telah digunakan.',
                    'code.min' => 'Kode Supplier minimal 10 huruf atau angka.',
                    'code.max' => 'Kode Supplier maksimal 10 huruf atau angka.',
                    'name.required' => 'Nama Supplier tidak boleh kosong.',
                    'name.min' => 'Nama Supplier minimal 3 huruf atau angka.',
                    'name.max' => 'Nama Supplier minimal 50 huruf atau angka.',
                    'email.email' => 'Email Supplier harus berupa format email.',
                    'email.unique' => 'Email yang sama telah digunakan.',
                    'email.max' => 'Email maksimal 50 huruf atau angka.',
                    'address_line_1.required' => 'Alamat Supplier Baris 1 tidak boleh kosong.',
                    'address_line_1.max' => 'Alamat Supplier Baris 1 maksimal 100 huruf atau angka.',
                    'address_line_2.max' => 'Alamat Supplier Baris 2 maksimal 100 huruf atau angka.',
                    'address_line_3.max' => 'Alamat Supplier Baris 3 maksimal 100 huruf atau angka.',
                    'address_line_4.max' => 'Alamat Supplier Baris 4 maksimal 100 huruf atau angka.',
                    'telp_no.required' => 'Nomor Telepon Supplier tidak boleh kosong.',
                    'telp_no.min' => 'Nomor Telepon Supplier minimal 5 huruf atau angka.',
                    'telp_no.max' => 'Nomor Telepon Supplier maksimal 20 huruf atau angka.',
                    'contact_person_1.required' => 'Nomor Kontak pertama yang dapat dihubungi tidak boleh kosong.',
                    'contact_person_1.min' => 'Nomor Kontak pertama minimal 12 huruf atau angka.',
                    'contact_person_1.max' => 'Nomor Kontak pertama maksimal 20 huruf atau angka.',
                    'contact_person_2.min' => 'Nomor Kontak kedua minimal 12 huruf atau angka.',
                    'contact_person_2.max' => 'Nomor Kontak kedua maksimal 20 huruf atau angka.',
                    'contact_person_3.min' => 'Nomor Kontak ketiga minimal 12 huruf atau angka.',
                    'contact_person_3.max' => 'Nomor Kontak ketiga maksimal 20 huruf atau angka.',
                    'contact_name_1.required' => 'Nama Kontak pertama yang dapat dihubungi tidak boleh kosong.',
                    'contact_name_1.min' => 'Nama Kontak pertama minimal 3 huruf atau angka.',
                    'contact_name_1.max' => 'Nama Kontak pertama maksimal 50 huruf atau angka.',
                    'contact_name_2.min' => 'Nama Kontak kedua minimal 3 huruf atau angka.',
                    'contact_name_2.max' => 'Nama Kontak kedua maksimal 50 huruf atau angka.',
                    'contact_name_3.min' => 'Nama Kontak ketiga minimal 3 huruf atau angka.',
                    'contact_name_3.max' => 'Nama Kontak ketiga maksimal 50 huruf atau angka.',
                ];
            case 'success':
                switch ($keyTwo) {
                    case 'create':
                        return 'Telah membuat supplier dengan sukses!';
                    case 'update':
                        return 'Telah memperbarui supplier dengan sukses!';
                    case 'delete':
                        return 'Telah menghapus supplier dengan sukses!';
                    default:
                        break;
                }
            case 'failDelete':
                return 'Supplier ini tidak dapat dihapus karena telah dipakai dimodul lain.';
            default:
                break;
        }
    }

    /**
     * rules of hs supplier module
     */
    public function rules(HsSupplier $hsSupplier) {
        $rule = [];
        if (isset($hsSupplier->splr_id)) {
            $rule['code'] = 'required|min:10|max:10|unique:hs_supplier,code,'.$hsSupplier->splr_id.',splr_id';
        } else {
            $rule['code'] = 'required|min:10|max:10|unique:hs_supplier';
        }

        $rule['name'] = 'required|min:3|max:50';

        if (isset($hsSupplier->email)) {
            if (isset($hsSupplier->splr_id)) {
                $rule['email'] = 'email|max:50|unique:hs_supplier,email,'.$hsSupplier->splr_id.',splr_id';
            } else {
                $rule['email'] = 'email|max:50|unique:hs_supplier';
            }
        }

        $rule['telp_no'] = 'required|min:5|max:20';
        $rule['contact_name_1'] = 'required|min:3|max:50';
        $rule['contact_person_1'] = 'required|min:12|max:20';
        
        if (isset($hsSupplier->contact_name_2) || isset($hsSupplier->contact_person_2)) {
            array_push($rule, [
                'contact_name_2' => 'min:3|max:50',
                'contact_person_2' => 'min:12|max:20',
            ]);
        }

        if (isset($hsSupplier->contact_name_3) || isset($hsSupplier->contact_person_3)) {
            array_push($rule, [
                'contact_name_3' => 'min:3|max:50',
                'contact_person_3' => 'min:12|max:20',
            ]);
        }

        $rule['address_line_1'] = 'required|max:100';

        if (isset($hsSupplier->address_line_2)) {
            $rule['address_line_2'] = 'max:100';
        }

        if (isset($hsSupplier->address_line_3)) {
            $rule['address_line_3'] = 'max:100';
        }

        if (isset($hsSupplier->address_line_4)) {
            $rule['address_line_4'] = 'max:100';
        }

        return $rule;
    }
}
