<?php

namespace App\Http\Controllers;

use App\Http\Requests\LuasTanamRequest;
use App\JumlahTanaman;
use App\Quarter;
use App\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class LuasTanamController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('luas_tanam_read'), 403);

        if ($request->ajax()) {
            $data = JumlahTanaman::with('user', 'quarter')
                ->with(['tanaman' => function($query) {
                    return $query->where('jenis', 'sawah');
                }]);

            if (!Gate::allows('luas_tanam_list')) {
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
                    if (Gate::allows('luas_tanam_update')) {
                        $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    }

                    if (Gate::allows('luas_tanam_delete')) {
                        $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    }
                    return ($btnEdit ?? '-') . ($btnDelete ?? '-');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $quarters = Quarter::all();
        $tanaman = Tanaman::where('jenis', 'sawah')
            ->get();

        return view('luas-tanam', compact(
            'quarters',
            'tanaman'
        ));
    }

    public function store(LuasTanamRequest $request)
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
            $result['msg'] = 'Jumlah luas tanam akhir minus, harap masukan jumlah luas yang valid.';
            return response()->json($result);
        }

        JumlahTanaman::create([
            'tanaman_id' => $request->tanaman_id,
            'tahun' => $request->tahun ?? date('Y'),
            'tanaman_awal' => $request->tanaman_awal,
            'sdg_menghasilkan' => $request->sdg_menghasilkan ?? 0,
            'luas_rusak' => $request->luas_rusak ?? 0,
            'ditambah' => $request->ditambah ?? 0,
            'produktifitas' => $request->produktifitas ?? 0,
            'produksi' => $request->produksi ?? 0,
            'user_id' => Auth::id(),
            'kuartal_id' => $request->kuartal_id ?? $kuartalId
        ]);
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit($id)
    {
        $luasTanam = JumlahTanaman::findOrFail($id);

        $result['data'] = $luasTanam;
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(LuasTanamRequest $request, $id)
    {
        $result['status'] = false;
        $luasTanam = JumlahTanaman::findOrFail($id);
        $kuartalId = Quarter::getIdActived();
        $tanaman = JumlahTanaman::where('tahun', $request->tahun ?? date('Y'))
            ->where('kuartal_id', $request->kuartal_id ?? $kuartalId)
            ->where('tanaman_id', $request->tanaman_id)
            ->where('id', '!=', $luasTanam->id)
            ->first();

        if ($tanaman) {
            $result['msg'] = 'Terdapat jenis tanaman yang sama, pada tahun dan kuartal tersebut.';
            return response()->json($result);
        }

        if ($this->sumTanaman($request) < 0) {
            $result['msg'] = 'Jumlah luas tanam akhir minus, harap masukan jumlah luas yang valid.';
            return response()->json($result);
        }

        $luasTanam->tanaman_id = $request->tanaman_id;
        $luasTanam->tahun = $request->tahun ?? date('Y');
        $luasTanam->tanaman_awal = $request->tanaman_awal;
        $luasTanam->sdg_menghasilkan = $request->sdg_menghasilkan ?? 0;
        $luasTanam->luas_rusak = $request->luas_rusak ?? 0;
        $luasTanam->ditambah = $request->ditambah ?? 0;
        $luasTanam->produktifitas = $request->produktifitas ?? 0;
        $luasTanam->produksi = $request->produksi ?? 0;
        $luasTanam->user_id = Auth::id();
        $luasTanam->kuartal_id = $request->kuartal_id ?? $kuartalId;
        $luasTanam->save();

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
            - $row->sdg_menghasilkan
            - $row->luas_rusak
            + $row->ditambah);
    }
}
