<?php

namespace App\Http\Controllers;

use App\KelompokTani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class KelompokTaniController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('kelompok_tani_management_access'), 403);

        if ($request->ajax()) {
            $data = KelompokTani::all();

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

        return view('kelompok-tani');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:32',
        ]);

        KelompokTani::create($request->only('nama'));

        return response()->json(['status' => true]);
    }

    public function edit(KelompokTani $kelompokTani)
    {
        $result['data'] = $kelompokTani;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(Request $request, KelompokTani $kelompokTani)
    {
        $request->validate([
            'nama' => 'required|string|max:32',
        ]);

        $kelompokTani->nama = $request->nama;
        $kelompokTani->save();

        return response()->json(['status' => true]);
    }

    public function destroy(KelompokTani $kelompokTani)
    {
        $kelompokTani->delete();

        return response()->json(['status' => true]);
    }
}
