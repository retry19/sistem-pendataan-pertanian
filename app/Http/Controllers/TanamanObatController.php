<?php

namespace App\Http\Controllers;

use App\Http\Requests\TanamanObatRequest;
use App\JumlahTanaman;
use App\Quarter;
use App\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class TanamanObatController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('tanaman_obat_read'), 403);

        if ($request->ajax()) {
            $data = JumlahTanaman::with('user', 'quarter', 'tanaman')
                ->whereHas('tanaman', fn($q) => $q->where('jenis', 'obat'));

            if (!Gate::allows('tanaman_obat_list')) {
                $data->where('tahun', date('Y'))
                    ->where('kuartal_id', Quarter::getIdActived());
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanaman_id', fn($row) => $row->tanaman->nama)
                ->editColumn('tanaman_awal', fn($row) => (float) $row->tanaman_awal)
                ->editColumn('dibongkar', fn($row) => (float) $row->dibongkar)
                ->editColumn('ditambah', fn($row) => (float) $row->ditambah)
                ->editColumn('sdg_menghasilkan', fn($row) => (float) $row->sdg_menghasilkan)
                ->editColumn('produksi', fn($row) => (float) $row->produksi)
                ->editColumn('luas_rusak', fn($row) => (float) $row->luas_rusak)
                ->addColumn('kuartal', fn($row) => $row->quarter->section)
                ->addColumn('tanaman_akhir', fn($row) => (float) $this->sumTanaman($row))
                ->editColumn('user_id', fn($row) => $row->user->name)
                ->addColumn('action', function($row) {
                    if (Gate::allows('tanaman_obat_update')) {
                        $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    }

                    if (Gate::allows('tanaman_obat_delete')) {
                        $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    }
                    return ($btnEdit ?? '-') . ($btnDelete ?? '-');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $quarters = Quarter::all();
        $tanaman = Tanaman::where('jenis', 'obat')
            ->get();

        return view('tanaman-obat', compact(
            'quarters',
            'tanaman'
        ));
    }

    public function store(TanamanObatRequest $request)
    {
        $result['status'] = false;
        
        $kuartalId = Quarter::getIdActived();
        $tanaman = JumlahTanaman::where('tahun', $request->tahun ?? date('Y'))
            ->where('kuartal_id', $request->kuartal_id ?? $kuartalId)
            ->where('tanaman_id', $request->tanaman_id)
            ->first();

        if ($tanaman) {
            $result['msg'] = 'Terdapat jenis tanaman yang sama, pada tahun dan kuartal tersebut.';
            return response()->json($result);
        }

        if ($this->sumTanaman($request) < 0) {
            $result['msg'] = 'Jumlah dari tanaman akhir minus, harap masukan jumlah luas yang valid.';
            return response()->json($result);
        }

        JumlahTanaman::create([
            'tanaman_id' => $request->tanaman_id,
            'tahun' => $request->tahun ?? date('Y'),
            'tanaman_awal' => $request->tanaman_awal,
            'dibongkar' => $request->dibongkar ?? 0,
            'sdg_menghasilkan' => $request->sdg_menghasilkan ?? 0,
            'ditambah' => $request->ditambah ?? 0,
            'produksi' => $request->produksi ?? 0,
            'luas_rusak' => $request->luas_rusak ?? 0,
            'user_id' => Auth::id(),
            'kuartal_id' => $request->kuartal_id ?? $kuartalId
        ]);
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit($id)
    {
        $tanamanObat = JumlahTanaman::findOrFail($id);

        $result['data'] = $tanamanObat;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(TanamanObatRequest $request, $id)
    {
        $result['status'] = false;
        $tanamanObat = JumlahTanaman::findOrFail($id);
        $kuartalId = Quarter::getIdActived();
        $tanaman = JumlahTanaman::where('tahun', $request->tahun ?? date('Y'))
            ->where('kuartal_id', $request->kuartal_id ?? $kuartalId)
            ->where('tanaman_id', $request->tanaman_id)
            ->where('id', '!=', $tanamanObat->id)
            ->first();

        if ($tanaman) {
            $result['msg'] = 'Terdapat jenis tanaman yang sama, pada tahun dan kuartal tersebut.';
            return response()->json($result);
        }

        if ($this->sumTanaman($request) < 0) {
            $result['msg'] = 'Jumlah dari tanaman akhir minus, harap masukan jumlah luas yang valid.';
            return response()->json($result);
        }

        $tanamanObat->tanaman_id = $request->tanaman_id;
        $tanamanObat->tahun = $request->tahun ?? date('Y');
        $tanamanObat->tanaman_awal = $request->tanaman_awal;
        $tanamanObat->dibongkar = $request->dibongkar ?? 0;
        $tanamanObat->sdg_menghasilkan = $request->sdg_menghasilkan ?? 0;
        $tanamanObat->ditambah = $request->ditambah ?? 0;
        $tanamanObat->produksi = $request->produksi ?? 0;
        $tanamanObat->luas_rusak = $request->luas_rusak ?? 0;
        $tanamanObat->user_id = Auth::id();
        $tanamanObat->kuartal_id = $request->kuartal_id ?? $kuartalId;
        $tanamanObat->save();

        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy($id)
    {
        JumlahTanaman::destroy($id);

        return response()->json(['status' => true]);
    }

    private function sumTanaman($row)
    {
        return ($row->tanaman_awal
            - $row->dibongkar
            - $row->luas_rusak
            + $row->ditambah);
    }
}
