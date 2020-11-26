<?php

namespace App\Http\Controllers;

use App\Hewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class HewanController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('hewan_management_access'), 403);

        if ($request->ajax()) {
            $data = Hewan::all();

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

        return view('hewan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:14',
        ]);

        Hewan::create($request->only('nama'));

        return response()->json(['status' => true]);
    }

    public function edit(Hewan $hewan)
    {
        $result['hewan'] = $hewan;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(Hewan $hewan, Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:14',
        ]);

        $hewan->nama = $request->nama;
        $hewan->save();

        return response()->json(['status' => true]);
    }

    public function destroy(Hewan $hewan)
    {
        $hewan->delete();

        return response()->json(['status' => true]);
    }
}
