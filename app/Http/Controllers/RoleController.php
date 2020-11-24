<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Permission;
use App\PermissionRole;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('users_management_access'), 403);

        if ($request->ajax()) {
            $data = Role::with('permissions')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('permissions', function($row) {
                    $permissions = '';
                    foreach ($row->permissions as $permission) {
                        $permissions .= "<span class=\"badge badge-info\">{$permission->title}</span>&nbsp;";
                    }

                    return $permissions;
                })
                ->addColumn('action', function($row) {
                    $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    return $btnEdit . $btnDelete;
                })
                ->rawColumns(['permissions', 'action'])
                ->make(true);
        }

        $permissions = Permission::get();

        return view('roles', compact('permissions'));
    }

    public function store(RoleStoreRequest $request)
    {
        $result['status'] = false;

        DB::transaction(function () use ($request) {
            $roleId = Role::create($request->only('name'))->id;

            $permissionRole = [];
            foreach ($request->permissions as $permission) {
                array_push($permissionRole, [
                    'permission_id' => $permission,
                    'role_id' => $roleId
                ]);
            }

            PermissionRole::insert($permissionRole);
        });

        $result['status'] = true;

        return response()->json($result);
    }

    public function edit(Role $role)
    {
        $result['data'] = $role;

        $permissionIds = [];
        foreach ($role->permissions as $permission) {
            $permissionIds[] = $permission->id;
        }

        $result['permissions'] = $permissionIds;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $result['status'] = false;

        DB::transaction(function () use ($request, $role) {
            $roleId = $role->id;

            $permissionRole = [];
            foreach ($request->permissions as $permission) {
                array_push($permissionRole, [
                    'permission_id' => $permission,
                    'role_id' => $roleId
                ]);
            }
            PermissionRole::where('role_id', $roleId)->delete();
            PermissionRole::insert($permissionRole);

            $role->name = $request->name;
            $role->save();
        });

        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();

        return response()->json(['status' => true]);
    }
}
