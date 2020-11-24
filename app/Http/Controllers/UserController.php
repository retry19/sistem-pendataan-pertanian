<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('users_management_access'), 403);

        if ($request->ajax()) {
            $data = User::with('roles')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('birth_date', fn($row) => $row->birth_date->format('d F Y'))
                ->addColumn('roles', function($row) {
                    $roles = '';
                    foreach ($row->roles as $role) {
                        $roles .= "<span class=\"badge badge-info\">{$role->name}</span>&nbsp;";
                    }

                    return $roles;
                })
                ->addColumn('action', function($row) {
                    $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    return $btnEdit . $btnDelete;
                })
                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        $roles = Role::all();

        return view('users.index', compact('roles'));
    }

    public function store(UserStoreRequest $request)
    {
        $result['status'] = false;

        DB::transaction(function () use ($request) {
            $userId = User::create([
                'name' => $request->name,
                'birth_date' => $request->birth_date,
                'username' => $request->username,
                'password' => Hash::make(Carbon::parse($request->birth_date)->format('dmY'))
            ])->id;

            $roleUsers = [];
            foreach ($request->roles as $role) {
                array_push($roleUsers, [
                    'role_id' => $role,
                    'user_id' => $userId
                ]);
            }

            RoleUser::insert($roleUsers);
        });

        $result['status'] = true;

        return response()->json($result);
    }

    public function edit(User $user)
    {
        $result['data'] = $user;

        $roleIds = [];
        foreach ($user->roles as $role) {
            $roleIds[] = $role->id;
        }

        $result['birth_date'] = $user->birth_date->format('Y-m-d');
        $result['roles'] = $roleIds;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $result['status'] = false;

        DB::transaction(function () use ($request, $user) {
            $userId = $user->id;

            $roleUser = [];
            foreach ($request->roles as $role) {
                array_push($roleUser, [
                    'role_id' => $role,
                    'user_id' => $userId
                ]);
            }
            RoleUser::where('user_id', $userId)->delete();
            RoleUser::insert($roleUser);

            $user->name = $request->name;
            $user->birth_date = $request->birth_date;
            $user->username = $request->username;
            $user->save();
        });

        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();

        return response()->json(['status' => true]);
    }

    public function profile()
    {
        $user = auth()->user();

        return view('users.profile', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->birth_date = $request->birth_date;
        $user->username = $request->username;

        $result['status'] = false;

        if ($request->password || $request->password_old) {
            $request->validate([
                'password' => 'required|string',
                'password_old' => 'required|string'
            ]);

            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password_old])) {
                $result['msg'] = 'Password yang anda masukan salah.';
                return response()->json($result);
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        $result['status'] = true;
        return response()->json($result);
    }
}
