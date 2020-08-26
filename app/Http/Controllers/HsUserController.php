<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MasterController;
use App\Models\HsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;

class HsUserController extends MasterController {

    /**
     * controller instance
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * view profile
     */
    public function getProfile() {
        // user model
        $user = auth()->user();

        // title
        $title = $this->getTitle('profile');

        return view('user.profile', compact('user', 'title'));
    }

    /**
     * save selected profile
     */
    public function saveProfile(Request $request) {
        // data from form submission
        $data = Input::all();

        // get current user session
        $hsUser = auth()->user();

        // validate form
        if($hsUser->validate($hsUser, $data, $hsUser->messages('validation'))) {
            DB::beginTransaction();
            try {
                $hsUser->user_name = $data['user_name'];
                $hsUser->email = $data['email'];
                $hsUser->phone = $data['phone'];
                $hsUser->password = Hash::make($data['password']);

                $hsUser->save();

                DB::commit();

                // db transaction success
                $this->setFlashMessage('success', $hsUser->messages('success', 'update'));
                return redirect($this->getRoute('profile'));
            } catch (Exception $e) {
                // db transaction error
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('profile'), $e);
            }
        } else {
            // form validation error
            $errors = $hsUser->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('profile'), $errors);
        }
    }

    /**
     * get route by prefix
     */
    public function getRoute($key, $id = null) {
        switch ($key) {
            case 'profile':
                return route('user.profile');
            default:
                break;
        }
    }
}