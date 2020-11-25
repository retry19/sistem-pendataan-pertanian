<?php

namespace App\Http\Controllers;

use App\Http\Requests\TanamanBuahRequest;
use App\JumlahTanaman;
use App\Quarter;
use App\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class TanamanBuahController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('tanaman_buah_read'), 403);

        if ($request->ajax()) {
            $data = JumlahTanaman::with('user', 'quarter', 'tanaman')
                ->whereHas('tanaman', fn($q) => $q->where('jenis', 'buah'));

            if (!Gate::allows('tanaman_buah_list')) {
                $data->where('tahun', date('Y'))
                    ->where('kuartal_id', Quarter::getIdActived());
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanaman_id', fn($row) => $row->tanaman->nama)
                ->addColumn('kuartal', fn($row) => $row->quarter->section)
                ->addColumn('tanaman_akhir', fn($row) => $this->sumTanaman($row))
                ->editColumn('user_id', fn($row) => $row->user->name)
                ->addColumn('action', function($row) {
                    if (Gate::allows('tanaman_buah_update')) {
                        $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    }

                    if (Gate::allows('tanaman_buah_delete')) {
                        $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    }
                    return ($btnEdit ?? '-') . ($btnDelete ?? '-');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $quarters = Quarter::all();
        $tanaman = Tanaman::where('jenis', 'buah')
            ->get();

        return view('tanaman-buah', compact(
            'quarters',
            'tanaman'
        ));
    }

    public function store(TanamanBuahRequest $request)
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
            'ditambah' => $request->ditambah ?? 0,
            'blm_menghasilkan' => $request->blm_menghasilkan ?? 0,
            'sdg_menghasilkan' => $request->sdg_menghasilkan ?? 0,
            'produksi' => $request->produksi ?? 0,
            'user_id' => Auth::id(),
            'kuartal_id' => $request->kuartal_id ?? $kuartalId
        ]);
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit($id)
    {
        $tanamanBuah = JumlahTanaman::findOrFail($id);

        $result['data'] = $tanamanBuah;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(TanamanBuahRequest $request, $id)
    {
        $result['status'] = false;
        $tanamanBuah = JumlahTanaman::findOrFail($id);
        $kuartalId = Quarter::getIdActived();
        $tanaman = JumlahTanaman::where('tahun', $request->tahun ?? date('Y'))
            ->where('kuartal_id', $request->kuartal_id ?? $kuartalId)
            ->where('tanaman_id', $request->tanaman_id)
            ->where('id', '!=', $tanamanBuah->id)
            ->first();

        if ($tanaman) {
            $result['msg'] = 'Terdapat jenis tanaman yang sama, pada tahun dan kuartal tersebut.';
            return response()->json($result);
        }

        if ($this->sumTanaman($request) < 0) {
            $result['msg'] = 'Jumlah dari tanaman akhir minus, harap masukan jumlah luas yang valid.';
            return response()->json($result);
        }

        $tanamanBuah->tanaman_id = $request->tanaman_id;
        $tanamanBuah->tahun = $request->tahun ?? date('Y');
        $tanamanBuah->tanaman_awal = $request->tanaman_awal;
        $tanamanBuah->dibongkar = $request->dibongkar ?? 0;
        $tanamanBuah->ditambah = $request->ditambah ?? 0;
        $tanamanBuah->blm_menghasilkan = $request->blm_menghasilkan ?? 0;
        $tanamanBuah->sdg_menghasilkan = $request->sdg_menghasilkan ?? 0;
        $tanamanBuah->produksi = $request->produksi ?? 0;
        $tanamanBuah->user_id = Auth::id();
        $tanamanBuah->kuartal_id = $request->kuartal_id ?? $kuartalId;
        $tanamanBuah->save();

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
            + $row->ditambah);
    }
}
