<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    return $btnEdit . $btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('permissions');
    }

    public function store(PermissionStoreRequest $request)
    {
        $result['status'] = false;

        Permission::create($request->only('title'));
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit(Permission $permission)
    {
        $result['data'] = $permission;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        $result['status'] = false;

        $permission->title = $request->title;
        $permission->save();
        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json(['status' => true]);
    }
}
