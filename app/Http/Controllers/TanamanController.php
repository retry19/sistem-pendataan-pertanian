<?php

namespace App\Http\Controllers;

use App\Http\Requests\TanamanRequest;
use App\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class TanamanController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('tanaman_management_access'), 403);

        if ($request->ajax()) {
            $data = Tanaman::get();

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

        return view('tanaman');
    }

    public function store(TanamanRequest $request)
    {
        Tanaman::create($request->validated());

        return response()->json(['status' => true]);
    }

    public function edit(Tanaman $tanaman)
    {
        $result['data'] = $tanaman;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(TanamanRequest $request, Tanaman $tanaman)
    {
        $tanaman->nama = $request->nama;
        $tanaman->jenis = $request->jenis;
        $tanaman->save();

        return response()->json(['status' => true]);
    }

    public function destroy(Tanaman $tanaman)
    {
        $tanaman->delete();

        return response()->json(['status' => true]);
    }
}
