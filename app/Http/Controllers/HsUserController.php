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
use App\Enums\StatusType;
use App\Enums\UserType;

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

        $hsUser->is_profile = 'YES';

        // validate form
        if($hsUser->validate($hsUser, $data, $hsUser->messages('validation'))) {
            DB::beginTransaction();
            try {
                $hsUser->user_name = $data['user_name'];
                $hsUser->email = $data['email'];
                $hsUser->phone = $data['phone'];
                $hsUser->password = Hash::make($data['password']);
                $hsUser->updated_at = now();

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

        $ddlStatus = StatusType::getStrings();

        return view('user.index', compact('title', 'ddlStatus'));
    }

    /**
     * display list of user
     */
    public function displayData(Request $request) {
        $rsUser = auth()->user()
            ->latest()
            ->where('is_admin', '!=', UserType::IsAdmin)
            ->select(['user_id', 'user_name', 'email', 'status']);
    
        return Datatables::of($rsUser)
            ->addColumn('action', function ($user) {
                $btn = "<a href='" . $this->getRoute('view', $user->user_id) . "' class='btn btn-info btn-sm'>Lihat</a>";
                $btn .= " <a href='" . $this->getRoute('edit', $user->user_id) . "' class='btn btn-warning btn-sm'>Ubah</a>";
                $btn .= " <button class='btn btn-danger btn-sm dlt-btn' onclick='trigDeleteModalBtn(\"".$this->getRoute("delete", $user->user_id)."\");'>Hapus</button>";

                return $btn;
            })
            ->editColumn('status', function($user) {
                $label = "<span class='badge badge-success'>".$user->status."</span>";

                if ($user->status == 'INACTIVE') {
                    $label = "<span class='badge badge-danger'>".$user->status."</span>";
                }

                return $label;
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status', $keyword);
            })
            ->rawColumns(['action', 'status'])
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
     * insert new user
     */
    public function store(Request $request) {
        $data = Input::all();

        $hsUser = new HsUser();

        if ($hsUser->validate($hsUser, $data, $hsUser->messages('validation'))) {
            DB::beginTransaction();

            try {
                $hsUser->user_name = $data['user_name'];
                $hsUser->email = $data['email'];
                $hsUser->phone = $data['phone'];
                $hsUser->password = Hash::make($data['password']);
                $hsUser->created_by = Auth()->user()->user_id;
                $hsUser->is_admin = UserType::NoAdmin;
                $hsUser->status = StatusType::ACTIVE;
                $hsUser->created_at = now();

                $hsUser->save();

                DB::commit();

                $this->setFlashMessage('success', $hsUser->messages('success', 'create'));
                return redirect($this->getRoute('index'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('create'), $e);
            }
        } else {
            $errors = $hsUser->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('create'), $errors);
        }
    }

    /**
     * edit
     */
    public function edit($id) {
        $userObj = HsUser::find($id);

        $title = $this->getTitle('edit_user');

        return view('user.edit', compact('title', 'userObj'));
    }

    /**
     * update
     */
    public function update(Request $request, $id) {
        $data = Input::all();

        $hsUser = HsUser::find($id);

        $data['user_id'] = $id;

        if ($hsUser->validate($hsUser, $data, $hsUser->messages('validation'))) {
            try {
                DB::beginTransaction();

                // set the bean
                $hsUser->user_name = $data['user_name'];
                $hsUser->email = $data['email'];
                $hsUser->phone = $data['phone'];
                $hsUser->password = Hash::make($data['password']);
                $hsUser->status = StatusType::ACTIVE;
                $hsUser->updated_at = now();
                $hsUser->save();

                DB::commit();
                $this->setFlashMessage('success', $hsUser->messages('success', 'update'));
                return redirect($this->getRoute('index'));
            } catch (\Exception $e) {
                DB::rollback();
                return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('edit', $id), $e);
            }
        } else {
            $errors = $hsUser->errors();
            return $this->redirectToRouteWithErrorsAndInputs($this->getRoute('edit', $id), $errors);
        }
    }

    /**
     * delete (mean not delete but terminating status into inactive only)
     */
    public function delete(Request $request, $id) {
        try {
            DB::beginTransaction();

            $hsUser = HsUser::find($id);
            $hsUser->status = StatusType::INACTIVE;
            $hsUser->updated_at = now();
            $hsUser->save();

            DB::commit();
            
            $this->setFlashMessage('success', $hsUser->messages('success', 'delete'));
            return redirect($this->getRoute('index'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->parseErrorAndRedirectToRouteWithErrors($this->getRoute('index'), $e);
        }
    }

    public function view($id) {
        $userModel = new HsUser();
        $userObj = $userModel::find($id);
        
        $title = $this->getTitle('view_user');

        return view('user.view', compact('title', 'userObj'));
    }

    /**
     * get route by prefix
     */
    public function getRoute($key, $id = null) {
        switch ($key) {
            case 'profile':
                return route('manage.user.profile');
            case 'index':
                return route('manage.user');
            case 'create':
                return route('manage.user.create');
            case 'view':
                return route('manage.user.view', $id);
            case 'edit':
                return route('manage.user.edit', $id);
            case 'delete':
                return route('manage.user.delete', $id);
            default:
                break;
        }
    }
}