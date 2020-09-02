<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MasterController;
use App\Models\HsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use Yajra\Datatables\Datatables;

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
     * list user management
     */
    public function index() {
        $title = $this->getTitle('manage_user');

        return view('user.index', compact('title'));
    }

    /**
     * display list of user
     */
    public function displayData(Request $request) {
        $rsUser = auth()->user()
            ->latest()
            ->where('is_admin', '!=', 'YES')
            ->get();

        return Datatables::of($rsUser)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                $btn = "<a href='javascript:void(0)' class='btn btn-info btn-sm'>Lihat</a>";
                $btn .= " <a href='javascript:void(0)' class='btn btn-warning btn-sm'>Ubah</a>";
                $btn .= " <a href='javascript:void(0)' class='btn btn-danger btn-sm'>Hapus</a>";

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * display create user view
     */
    public function create() {
        $title = $this->getTitle('create_user');

        return view('user.create', compact('title'));
    }

    /**
     * get route by prefix
     */
    public function getRoute($key, $id = null) {
        switch ($key) {
            case 'profile':
                return route('user.profile');
            case 'index':
                return route('user.index');
            default:
                break;
        }
    }
}