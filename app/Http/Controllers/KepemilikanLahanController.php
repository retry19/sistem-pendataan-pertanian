<?php

namespace App\Http\Controllers;

use App\Http\Requests\KepemilikanLahanRequest;
use App\KelompokTani;
use App\KepemilikanLahan;
use App\Quarter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class KepemilikanLahanController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('kepemilikan_lahan_read'), 403);

        if ($request->ajax()) {
            $data = KepemilikanLahan::with('user', 'quarter', 'kelompokTani');

            if (!Gate::allows('kepemilikan_lahan_list')) {
                $data->where('tahun', date('Y'))
                    ->where('kuartal_id', Quarter::getIdActived());
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('kelompok_tani_id', fn($row) => $row->kelompokTani->nama)
                ->addColumn('kuartal', fn($row) => $row->quarter->section)
                ->editColumn('user_id', fn($row) => $row->user->name)
                ->addColumn('action', function($row) {
                    if (Gate::allows('kepemilikan_lahan_update')) {
                        $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    }

                    if (Gate::allows('kepemilikan_lahan_delete')) {
                        $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    }
                    return ($btnEdit ?? '-') . ($btnDelete ?? '-');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $quarters = Quarter::all();
        $kelompokTani = KelompokTani::all();

        return view('kepemilikan-lahan', compact(
            'kelompokTani',
            'quarters'
        ));
    }

    public function store(KepemilikanLahanRequest $request)
    {
        $result['status'] = false;
        
        $kuartalId = Quarter::getIdActived();

        KepemilikanLahan::create([
            'kelompok_tani_id' => $request->kelompok_tani_id,
            'tahun' => $request->tahun ?? date('Y'),
            'blok' => $request->blok,
            'pemilik' => $request->pemilik,
            'luas_sawah' => $request->luas_sawah,
            'luas_rencana' => $request->luas_rencana,
            'alamat' => $request->alamat,
            'user_id' => Auth::id(),
            'kuartal_id' => $request->kuartal_id ?? $kuartalId
        ]);
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit(KepemilikanLahan $kepemilikanLahan)
    {
        $result['data'] = $kepemilikanLahan;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(KepemilikanLahanRequest $request, KepemilikanLahan $kepemilikanLahan)
    {
        $result['status'] = false;

        $kuartalId = Quarter::getIdActived();

        $kepemilikanLahan->kelompok_tani_id = $request->kelompok_tani_id;
        $kepemilikanLahan->tahun = $request->tahun ?? date('Y');
        $kepemilikanLahan->blok = $request->blok;
        $kepemilikanLahan->pemilik = $request->pemilik;
        $kepemilikanLahan->luas_sawah = $request->luas_sawah;
        $kepemilikanLahan->luas_rencana = $request->luas_rencana;
        $kepemilikanLahan->alamat = $request->alamat;
        $kepemilikanLahan->user_id = Auth::id();
        $kepemilikanLahan->kuartal_id = $request->kuartal_id ?? $kuartalId;

        $kepemilikanLahan->save();

        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy(KepemilikanLahan $kepemilikanLahan)
    {
        $kepemilikanLahan->delete();

        return response()->json(['status' => true]);
    }
}
