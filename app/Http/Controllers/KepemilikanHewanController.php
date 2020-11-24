<?php

namespace App\Http\Controllers;

use App\Hewan;
use App\Http\Requests\KepemilikanHewanStoreRequest;
use App\JumlahKepemilikanHewan;
use App\Quarter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class KepemilikanHewanController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('kepemilikan_hewan_read'), 403);

        if ($request->ajax()) {
            $data = JumlahKepemilikanHewan::with('hewan', 'quarter', 'user');

            if (!Gate::allows('kepemilikan_hewan_list')) {
                $data->where('tahun', date('Y'))
                    ->where('kuartal_id', Quarter::getIdActived());
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('hewan_id', fn($row) => $row->hewan->nama)
                ->editColumn('user_id', fn($row) => $row->user->name)
                ->addColumn('kuartal', fn($row) => $row->quarter->section)
                ->addColumn('action', function($row) {
                    if (Gate::allows('kepemilikan_hewan_update')) {
                        $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    }

                    if (Gate::allows('kepemilikan_hewan_delete')) {
                        $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    }
                    return ($btnEdit ?? '-') . ($btnDelete ?? '-');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $hewan = Hewan::all();
        $quarters = Quarter::all();

        return view('kepemilikan-hewan', compact(
            'hewan',
            'quarters'
        ));
    }

    public function store(KepemilikanHewanStoreRequest $request)
    {
        $result['status'] = false;
        $kuartalId = Quarter::getIdActived();

        JumlahKepemilikanHewan::create([
            'hewan_id' => $request->hewan_id,
            'blok' => $request->blok,
            'pemilik' => $request->pemilik,
            'jumlah' => $request->jumlah,
            'tahun' => $request->tahun ?? date('Y'),
            'user_id' => Auth::id(),
            'kuartal_id' => $request->kuartal_id ?? $kuartalId
        ]);
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit($id)
    {
        $jumlahKepemilikanHewan = JumlahKepemilikanHewan::findOrFail($id);

        $result['data'] = $jumlahKepemilikanHewan;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(KepemilikanHewanStoreRequest $request, $id)
    {
        $result['status'] = false;

        $jumlahKepemilikanHewan = JumlahKepemilikanHewan::findOrFail($id);
        $kuartalId = Quarter::getIdActived();

        $jumlahKepemilikanHewan->hewan_id = $request->hewan_id;
        $jumlahKepemilikanHewan->blok = $request->blok;
        $jumlahKepemilikanHewan->pemilik = $request->pemilik;
        $jumlahKepemilikanHewan->jumlah = $request->jumlah;
        $jumlahKepemilikanHewan->tahun = $request->tahun ?? date('Y');
        $jumlahKepemilikanHewan->user_id = Auth::id();
        $jumlahKepemilikanHewan->kuartal_id = $request->kuartal_id ?? $kuartalId;

        $jumlahKepemilikanHewan->save();
        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy($id)
    {
        JumlahKepemilikanHewan::destroy($id);

        return response()->json(['status' => true]);
    }
}
