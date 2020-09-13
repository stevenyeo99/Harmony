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
    public function getTitle(String $key) {
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
            case 'manage_item':
                $title = "Manajemen Item";
                break;
            case 'create_item_detail':
                $title = "Buat Item";
                break;
            case 'create_item_category':
                $title = "Buat kategori Item";
                break;
            case 'view_item_detail':
                $title = "Detail Item";
                break;
            case 'edit_item_detail':
                $title = "Edit Item";
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