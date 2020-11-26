<?php

namespace App\Http\Controllers;

use App\Dokumentasi;
use App\Http\Requests\DokumentasiRequest;
use App\Quarter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DokumentasiController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('dokumentasi_read'), 403);

        if ($request->ajax()) {
            $data = Dokumentasi::with('user', 'quarter');

            if (!Gate::allows('dokumentasi_list')) {
                $data->whereYear('tanggal', date('Y'))
                    ->where('kuartal_id', Quarter::getIdActived());
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal->format('d F Y'))
                ->editColumn('gambar', fn($row) => "<img src=\"".asset("storage/{$row->gambar}")."\" height=\"100\">")
                ->editColumn('kuartal_id', fn($row) => $row->quarter->section)
                ->editColumn('user_id', fn($row) => $row->user->name)
                ->addColumn('action', function($row) {
                    if (Gate::allows('dokumentasi_update')) {
                        $btnEdit = "<button type=\"button\" class=\"btn btn-sm btn-info rounded-lg button-edit\" data-id=\"{$row->id}\" onclick=\"onClickEdit(event)\"><i class=\"fas fa-edit\" data-id=\"{$row->id}\"></i></button> ";
                    }

                    if (Gate::allows('dokumentasi_delete')) {
                        $btnDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger rounded-lg button-delete\" data-id=\"{$row->id}\" onclick=\"onClickDelete(event)\"><i class=\"fas fa-trash\" data-id=\"{$row->id}\"></i></button>";
                    }
                    return ($btnEdit ?? '-') . ($btnDelete ?? '-');
                })
                ->rawColumns(['gambar', 'action'])
                ->make(true);
        }

        $quarters = Quarter::all();
        return view('dokumentasi', compact('quarters'));
    }

    public function store(DokumentasiRequest $request)
    {
        $result['status'] = false;

        $kuartalId = Quarter::getIdActived();

        $image = Storage::disk('public')->put('dokumentasi', $request->file('gambar'));
        if (!Storage::disk('public')->exists($image)) {
            return response()->json($result);
        }

        Dokumentasi::create([
            'gambar' => $image,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'user_id' => Auth::id(),
            'kuartal_id' => $request->kuartal_id ?? $kuartalId
        ]);
        $result['status'] = true;

        return response()->json($result);
    }

    public function edit(Dokumentasi $dokumentasi)
    {
        $result['data'] = $dokumentasi;
        $result['tanggal'] = $dokumentasi->tanggal->format('Y-m-d');
        $result['status'] = true;

        return response()->json($result);
    }

    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        $request->validate([
            'gambar' => 'nullable|image|max:5000',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date'
        ]);

        $result['status'] = false;
        $kuartalId = Quarter::getIdActived();

        if ($request->file('gambar')) {
            if (Storage::disk('public')->exists($dokumentasi->gambar)) {
                Storage::disk('public')->delete($dokumentasi->gambar);
            }

            $dokumentasi->gambar = Storage::disk('public')->put('dokumentasi', $request->file('gambar'));
        }

        $dokumentasi->deskripsi = $request->deskripsi;
        $dokumentasi->tanggal = $request->tanggal;
        $dokumentasi->kuartal_id = $request->kuartal_id ?? $kuartalId;
        $dokumentasi->user_id = Auth::id();
        $dokumentasi->save();

        $result['status'] = true;

        return response()->json($result);
    }

    public function destroy(Dokumentasi $dokumentasi)
    {
        if (Storage::disk('public')->exists($dokumentasi->gambar)) {
            Storage::disk('public')->delete($dokumentasi->gambar);
        }

        $dokumentasi->delete();

        return response()->json(['status' => true]);
    }
}
