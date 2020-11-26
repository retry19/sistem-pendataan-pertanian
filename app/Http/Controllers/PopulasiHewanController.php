<?php

namespace App\Http\Controllers;

use App\Hewan;
use App\Http\Requests\PopulasiHewanStoreRequest;
use App\PopulasiHewan;
use App\Quarter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class PopulasiHewanController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('populasi_hewan_read'), 403);

        if ($request->ajax()) {
            $data = PopulasiHewan::with('hewan', 'quarter', 'user');

            if (!Gate::allows('populasi_hewan_list')) {
                $data->where('tahun', date('Y'))
                    ->where('kuartal_id', Quarter::getIdActived());
            }
            
            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('hewan_id', fn($row) => $row->hewan->nama)
                ->editColumn('user_id', fn($row) => $row->user->name)
                ->addColumn('kuartal', fn($row) => $row->quarter->section)
                ->addColumn('awal_jan', fn($row) => $row->populasi_awal['jantan'])
                ->addColumn('awal_bet', fn($row) => $row->populasi_awal['betina'])
                ->addColumn('lahir_jan', fn($row) => $row->lahir['jantan'])
                ->addColumn('lahir_bet', fn($row) => $row->lahir['betina'])
                ->addColumn('dipotong_jan', fn($row) => $row->dipotong['jantan'])
                ->addColumn('dipotong_bet', fn($row) => $row->dipotong['betina'])
                ->addColumn('mati_jan', fn($row) => $row->mati['jantan'])
                ->addColumn('mati_bet', fn($row) => $row->mati['betina'])
                ->addColumn('masuk_jan', fn($row) => $row->masuk['jantan'])
                ->addColumn('masuk_bet', fn($row) => $row->masuk['betina'])
                ->addColumn('keluar_jan', fn($row) => $row->keluar['jantan'])
                ->addColumn('keluar_bet', fn($row) => $row->keluar['betina'])
                ->addColumn('akhir_jan', fn($row) => $this->sumPopulasi($row, 'jantan'))
                ->addColumn('akhir_bet', fn($row) => $this->sumPopulasi($row, 'betina'))
                ->addColumn('action', function($row) {
                    if (Gate::allows('populasi_hewan_update')) {
                        $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    }

                    if (Gate::allows('populasi_hewan_delete')) {
                        $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    }
                    return ($btnEdit ?? '-') . ($btnDelete ?? '-');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $hewan = Hewan::all();
        $quarters = Quarter::all();

        return view('populasi-hewan', compact(
            'hewan',
            'quarters'
        ));
    }

    public function store(PopulasiHewanStoreRequest $request)
    {
        $result['status'] = false;
        
        $kuartalId = Quarter::getIdActived();
        $hewan = PopulasiHewan::where('tahun', $request->tahun ?? date('Y'))
            ->where('kuartal_id', $request->kuartal_id ?? $kuartalId)
            ->where('hewan_id', $request->hewan_id)
            ->first();

        if ($hewan) {
            $result['msg'] = 'Terdapat jenis ternak yang sama, pada tahun dan kuartal tersebut.';
            return response()->json($result);
        }

        $populasiAkhir['jantan'] = $request->populasi_awal_jantan
            + ($request->jumlah_lahir_jantan ?? 0)
            - ($request->jumlah_dipotong_jantan ?? 0)
            - ($request->jumlah_mati_jantan ?? 0)
            + ($request->jumlah_masuk_jantan ?? 0)
            - ($request->jumlah_keluar_jantan ?? 0);
        $populasiAkhir['betina'] = $request->populasi_awal_betina
            + ($request->jumlah_lahir_betina ?? 0)
            - ($request->jumlah_dipotong_betina ?? 0)
            - ($request->jumlah_mati_betina ?? 0)
            + ($request->jumlah_masuk_betina ?? 0)
            - ($request->jumlah_keluar_betina ?? 0);

        if ($populasiAkhir['jantan'] < 0 || $populasiAkhir['betina'] < 0) {
            $result['msg'] = 'Populasi akhir hewan minus, harap masukan jumlah ternak yang valid.';
            return response()->json($result);
        }

        $populasiHewan = [
            'hewan_id' => $request->hewan_id,
            'populasi_awal' => [
                'jantan' => $request->populasi_awal_jantan,
                'betina' => $request->populasi_awal_betina
            ],
            'lahir' => [
                'jantan' => $request->jumlah_lahir_jantan,
                'betina' => $request->jumlah_lahir_betina
            ],
            'dipotong' => [
                'jantan' => $request->jumlah_dipotong_jantan,
                'betina' => $request->jumlah_dipotong_betina
            ],
            'mati' => [
                'jantan' => $request->jumlah_mati_jantan,
                'betina' => $request->jumlah_mati_betina
            ],
            'masuk' => [
                'jantan' => $request->jumlah_masuk_jantan,
                'betina' => $request->jumlah_masuk_betina
            ],
            'keluar' => [
                'jantan' => $request->jumlah_keluar_jantan,
                'betina' => $request->jumlah_keluar_betina
            ],
            'tahun' => $request->tahun ?? date('Y'),
            'user_id' => Auth::id(),
            'kuartal_id' => $request->kuartal_id ?? Quarter::getIdActived()
        ];

        PopulasiHewan::create($populasiHewan);
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit(PopulasiHewan $populasiHewan)
    {
        $result['data'] = $populasiHewan;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(PopulasiHewanStoreRequest $request, PopulasiHewan $populasiHewan)
    {
        $result['status'] = false;
        
        $kuartalId = Quarter::getIdActived();
        $hewan = PopulasiHewan::where('tahun', $request->tahun ?? date('Y'))
            ->where('kuartal_id', $request->kuartal_id ?? $kuartalId)
            ->where('hewan_id', $request->hewan_id)
            ->where('id', '!=', $populasiHewan->id)
            ->first();

        if ($hewan) {
            $result['msg'] = 'Terdapat jenis ternak yang sama, pada tahun dan kuartal tersebut.';
            return response()->json($result);
        }

        $populasiAkhir['jantan'] = $request->populasi_awal_jantan
            + ($request->jumlah_lahir_jantan ?? 0)
            - ($request->jumlah_dipotong_jantan ?? 0)
            - ($request->jumlah_mati_jantan ?? 0)
            + ($request->jumlah_masuk_jantan ?? 0)
            - ($request->jumlah_keluar_jantan ?? 0);
        $populasiAkhir['betina'] = $request->populasi_awal_betina
            + ($request->jumlah_lahir_betina ?? 0)
            - ($request->jumlah_dipotong_betina ?? 0)
            - ($request->jumlah_mati_betina ?? 0)
            + ($request->jumlah_masuk_betina ?? 0)
            - ($request->jumlah_keluar_betina ?? 0);

        if ($populasiAkhir['jantan'] < 0 || $populasiAkhir['betina'] < 0) {
            $result['msg'] = 'Populasi akhir hewan minus, harap masukan jumlah ternak yang valid.';
            return response()->json($result);
        }

        
        $populasiHewan->hewan_id = $request->hewan_id;
        $populasiHewan->populasi_awal = [
            'jantan' => $request->populasi_awal_jantan,
            'betina' => $request->populasi_awal_betina
        ];
        $populasiHewan->lahir = [
            'jantan' => $request->jumlah_lahir_jantan,
            'betina' => $request->jumlah_lahir_betina
        ];
        $populasiHewan->dipotong = [
            'jantan' => $request->jumlah_dipotong_jantan,
            'betina' => $request->jumlah_dipotong_betina
        ];
        $populasiHewan->mati = [
            'jantan' => $request->jumlah_mati_jantan,
            'betina' => $request->jumlah_mati_betina
        ];
        $populasiHewan->masuk = [
            'jantan' => $request->jumlah_masuk_jantan,
            'betina' => $request->jumlah_masuk_betina
        ];
        $populasiHewan->keluar = [
            'jantan' => $request->jumlah_keluar_jantan,
            'betina' => $request->jumlah_keluar_betina
        ];
        $populasiHewan->tahun = $request->tahun ?? date('Y');
        $populasiHewan->user_id = Auth::id();
        $populasiHewan->kuartal_id = $request->kuartal_id ?? Quarter::getIdActived();

        $populasiHewan->save();
        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy(PopulasiHewan $populasiHewan)
    {
        $populasiHewan->delete();

        return response()->json(['status' => true]);
    }

    private function sumPopulasi($row, $gender)
    {
        return ($row->populasi_awal[$gender]
            + ($row->lahir[$gender] ?? 0)
            - ($row->dipotong[$gender] ?? 0)
            - ($row->mati[$gender] ?? 0)
            + ($row->masuk[$gender] ?? 0)
            - ($row->keluar[$gender] ?? 0));
    }
}
