<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class MasterController extends Controller {

    private $multipleFlashMessageArr = [];

    /**
     * get each module title
     */
    public function getTitle(String $key, String $key2 = null) {
        switch ($key) {
            case 'home':
                $title = "Beranda";
                break;
            case 'diagram':
                $title = "Diagram Pembelian/Penjualan";
                break;
            case 'profile':
                $title = "Profil User";
                break;
            case 'manage_user':
                $title = "Manajemen User";
                break;
            case 'create_user':
                $title = "Buat User";
                break;
            case 'view_user':
                $title = "Detail User";
                break;
            case 'edit_user':
                $title = "Edit User";
                break;
            case 'manage_supplier':
                $title = "Manajemen Supplier";
                break;
            case 'create_supplier':
                $title = "Buat Supplier";
                break;
            case 'view_supplier':
                $title = "Detail Supplier";
                break;
            case 'edit_supplier':
                $title = "Edit Supplier";
                break;
            case 'manage_item_detail':
                $title = "Manajemen Item";
                break;
            case 'manage_item_category':
                $title = "Manajemen Kategori Item";
                break;
            case 'manage_item_uom':
                $title = "Manajemen Jenis Unit";
                break;
            case 'manage_purchase':
                $title = "Manajemen Pembelian";
                break;
            case 'manage_invoice':
                $title = "Manajemen Penjualan";
                break;
            case 'manage_item_stock':
                $title = "Detail Transaksi Stock Item " . $key2;
                break;
            case 'create_item_detail':
                $title = "Buat Item";
                break;
            case 'create_item_category':
                $title = "Buat kategori Item";
                break;
            case 'create_item_uom':
                $title = "Buat Jenis Unit";
                break;
            case 'create_purchase':
                $title = "Buat Pembelian";
                break;
            case 'create_invoice':
                $title = "Buat Transaksi Penjualan";
                break;
            case 'view_item_detail':
                $title = "Detail Item";
                break;
            case 'view_item_category':
                $title = "Detail Kategori Item";
                break;
            case 'view_item_uom':
                $title = "Detail Jenis Unit";
                break;
            case 'view_purchase':
                $title = "Detail Pembelian";
                break;
            case 'view_invoice':
                $title = "Detail Penjualan";
                break;
            case 'edit_item_detail':
                $title = "Edit Item";
                break;
            case 'edit_item_category':
                $title = "Edit Kategori Item";
                break;
            case 'edit_item_uom':
                $title = "Edit Jenis Unit";
                break;
            case 'edit_purchase':
                $title = "Edit Pembelian";
                break;
            case 'edit_invoice':
                $title = "Edit Transaksi Penjualan";
                break;
            case 'edit_item_stock':
                $title = "Atur Kuantiti Stock Item " . $key2;
                break;
            case 'report_item':
                $title = "Export laporan data item";
                break;
            case 'report_supplier':
                $title = "Export laporan data supplier";
                break;
            case 'report_transaction_item':
                $title = "Export laporan transaksi item";
                break;
            case 'report_transaction_purchase':
                $title = "Export laporan transaksi pembelian";
                break;
            case 'report_transaction_invoice':
                $title = "Export laporan transaksi penjualan";
                break;
            default:
                return '';
        }
        return $title;
    }

    /**
     * trigger alert message
     */
    public function setFlashMessage(string $alertType, string $message) {
        Session::flash('message', $message);
        Session::flash('alert-type', $alertType);
    }

    /**
     * add multiple alert message
     */
    public function setMultipleFlashMessageArr(string $alertType, string $message) {
        array_push($this->multipleFlashMessageArr, ['alert-type' => $alertType, 'message' => $message]);
    }

    /**
     * trigger multiple alert message
     */
    public function fireMultipleFlashMessage() {
        Session::flash('messages', $this->multipleFlashMessageArr);
    }

    /**
     * reset the array of multiple alert message
     */
    public function resetMultipleFlashMessageArr() {
        $this->multipleFlashMessageArr = [];
    }

    /**
     * get action buttons related the module
     */
    public function getActionsButtons($model, array $extraClassToAdd = []) {

    }

    /**
     * get the error and redirect to route with errors and inputs
     */
    public function parseErrorAndRedirectToRouteWithErrors(string $route, $e) {
        if (is_string($e)) {
            $errors = new MessageBag([$e]);
        } else {
            $errors = new MessageBag(method_exists($e, 'getMessage') ? [$e->getMessage()] : $e->all());
        }

        return $this->redirectToRouteWithErrorsAndInputs($route, $errors);
    } 

    /**
     * redirect to route with errors and inputs
     */
    public function redirectToRouteWithErrorsAndInputs(string $route, $errors) {
        return redirect($route)
            ->with('errors', $errors)
            ->withInput();
    }
}