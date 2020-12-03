<?php

namespace App\Http\Controllers;

use App\Hewan;
use App\JumlahKepemilikanHewan;
use App\JumlahTanaman;
use App\KepemilikanLahan;
use App\PopulasiHewan;
use App\Quarter;
use App\Tanaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $kuartalId = Quarter::getIdActived();

        $qtyHewan = PopulasiHewan::where('tahun', date('Y'))
            ->where('kuartal_id', $kuartalId)
            ->count();
        $qtyLuasLahan = JumlahTanaman::with('tanaman')
            ->where('tahun', date('Y'))
            ->where('kuartal_id', $kuartalId)
            ->whereHas('tanaman', fn($q) => $q->where('jenis', 'sawah'))
            ->count();
        $qtyTanaman = JumlahTanaman::with('tanaman')
            ->where('tahun', date('Y'))
            ->where('kuartal_id', $kuartalId)
            ->whereHas('tanaman', fn($q) => $q->where('jenis', '!=', 'sawah'))
            ->count();
        $qtyKepemilikanLahan = KepemilikanLahan::where('tahun', date('Y'))
            ->where('kuartal_id', $kuartalId)
            ->count();

        $countHewan = Hewan::count();
        $countSawah = Tanaman::where('jenis', 'sawah')->count();
        $countTanaman = Tanaman::where('jenis', '!=', 'sawah')->count();

        $kepemilikanLahanPerKelompokTani = KepemilikanLahan::with('kelompokTani')
            ->where('tahun', date('Y'))
            ->where('kuartal_id', $kuartalId)
            ->select('kelompok_tani_id')
            ->selectRaw('SUM(luas_sawah) as total_luas_sawah')
            ->selectRaw('SUM(luas_rencana) as total_luas_rencana')
            ->groupBy('kelompok_tani_id')
            ->get();

        return view('main', compact(
            'qtyHewan',
            'qtyLuasLahan',
            'qtyTanaman',
            'qtyKepemilikanLahan',
            'countHewan',
            'countSawah',
            'countTanaman',
            'kepemilikanLahanPerKelompokTani',
        ));
    }
}
