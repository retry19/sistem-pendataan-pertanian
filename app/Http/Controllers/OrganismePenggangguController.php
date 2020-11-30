<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganismePenggangguRequest;
use App\OrganismePengganggu;
use App\Quarter;
use App\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class OrganismePenggangguController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('organisme_pengganggu_read'), 403);

        if ($request->ajax()) {
            $data = OrganismePengganggu::with('user', 'quarter', 'tanaman');

            if (!Gate::allows('organisme_pengganggu_list')) {
                $data->where('tahun', date('Y'))
                    ->where('kuartal_id', Quarter::getIdActived());
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanaman_id', fn($row) => $row->tanaman->nama)
                ->editColumn('luas_serangan', fn($row) => (float) $row->luas_serangan)
                ->addColumn('kuartal', fn($row) => $row->quarter->section)
                ->editColumn('user_id', fn($row) => $row->user->name)
                ->addColumn('action', function($row) {
                    if (Gate::allows('organisme_pengganggu_update')) {
                        $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    }

                    if (Gate::allows('organisme_pengganggu_delete')) {
                        $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    }
                    return ($btnEdit ?? '-') . ($btnDelete ?? '-');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $quarters = Quarter::all();
        $tanaman = Tanaman::all();

        return view('organisme-pengganggu', compact(
            'quarters',
            'tanaman'
        ));
    }

    public function store(OrganismePenggangguRequest $request)
    {
        $result['status'] = false;
        
        $kuartalId = Quarter::getIdActived();

        OrganismePengganggu::create([
            'tanaman_id' => $request->tanaman_id,
            'tahun' => $request->tahun ?? date('Y'),
            'bencana' => $request->bencana,
            'luas_serangan' => $request->luas_serangan,
            'upaya' => $request->upaya,
            'user_id' => Auth::id(),
            'kuartal_id' => $request->kuartal_id ?? $kuartalId
        ]);
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit(OrganismePengganggu $organismePengganggu)
    {
        $result['data'] = $organismePengganggu;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(OrganismePenggangguRequest $request, OrganismePengganggu $organismePengganggu)
    {
        $result['status'] = false;

        $kuartalId = Quarter::getIdActived();

        $organismePengganggu->tanaman_id = $request->tanaman_id;
        $organismePengganggu->tahun = $request->tahun ?? date('Y');
        $organismePengganggu->bencana = $request->bencana;
        $organismePengganggu->luas_serangan = $request->luas_serangan;
        $organismePengganggu->upaya = $request->upaya;
        $organismePengganggu->user_id = Auth::id();
        $organismePengganggu->kuartal_id = $request->kuartal_id ?? $kuartalId;
        $organismePengganggu->save();

        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy(OrganismePengganggu $organismePengganggu)
    {
        $organismePengganggu->delete();

        return response()->json(['status' => true]);
    }

}
