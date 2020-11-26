<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanKepemilikanHewanTernakRequest;
use App\Http\Requests\LaporanKepemilikanLahanPertanianRequest;
use App\Http\Requests\LaporanTanamanPanganPeternakanRequest;
use App\JumlahKepemilikanHewan;
use App\JumlahTanaman;
use App\KepemilikanLahan;
use App\Quarter;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class LaporanController extends Controller
{
    public function tanamanPanganPeternakan()
    {
        $quarters = Quarter::all();

        return view('laporan.tanaman-pangan-peternakan', compact('quarters'));
    }

    public function tanamanPanganPeternakanPDF(LaporanTanamanPanganPeternakanRequest $request)
    {
        $border = 0;

        $kuartal = Quarter::findOrFail($request->kuartal_id);
        $luasTanam = JumlahTanaman::with('tanaman', 'user', 'quarter')
            ->whereHas('tanaman', fn($q) => $q->where('jenis', 'sawah'))
            ->where('tahun', $request->tahun)
            ->where('kuartal_id', $kuartal->id)
            ->get();
        $tanamanBuah = JumlahTanaman::with('tanaman', 'user', 'quarter')
            ->whereHas('tanaman', fn($q) => $q->where('jenis', 'buah'))
            ->where('tahun', $request->tahun)
            ->where('kuartal_id', $kuartal->id)
            ->get();
        $tanamanObat = JumlahTanaman::with('tanaman', 'user', 'quarter')
            ->whereHas('tanaman', fn($q) => $q->where('jenis', 'obat'))
            ->where('tahun', $request->tahun)
            ->where('kuartal_id', $kuartal->id)
            ->get();
        $tanamanKebun = JumlahTanaman::with('tanaman', 'user', 'quarter')
            ->whereHas('tanaman', fn($q) => $q->where('jenis', 'kebun'))
            ->where('tahun', $request->tahun)
            ->where('kuartal_id', $kuartal->id)
            ->get();

        $pdf = new Fpdf;
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 7, 'LAPORAN BULANAN TANAMAN PANGAN DAN PETERNAKAN', $border, 1, 'C');       
        $pdf->SetX(70);
        $pdf->SetFont('');
        $pdf->Cell(30, 5, 'TRIWULAN', $border, 0);
        $pdf->Cell(5, 5, ':', $border, 0);
        $pdf->Cell(30, 5, $kuartal->section, $border, 0);
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(30, 5, 'DESA', $border, 0);
        $pdf->Cell(5, 5, ':', $border, 0);
        $pdf->Cell(30, 5, 'Ciawigebang', $border, 0);
        $pdf->Ln(10);
        
        $pdf->SetXY(150, 25);
        $pdf->SetFont('Arial','B', 14);
        $pdf->Cell(50, 10, 'ASLI (EKBANG)', 1, 1, 'C');

        // LAPORAN LUAS TANAM DAN PANEN
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(70, 7, 'A. LAPORAN LUAS TANAM DAN PANEN', $border, 1);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 10, 'No', 1, 0, 'C');
        $pdf->Cell(49, 10, 'Jenis Tanaman', 1, 0, 'C');
        $pdf->MultiCell(23, 5, 'Tanaman Bulan Lalu (ha)', 1, 'C');
        $pdf->SetXY(89, $y);
        $pdf->Cell(15, 10, 'Panen', 1, 0,'C');
        $pdf->Cell(15, 10, 'Puso', 1, 0,'C');
        $pdf->SetXY(119, $y);
        $pdf->MultiCell(21, 5, 'Tambah Tanaman (ha)', 1, 'C');
        $pdf->SetXY(140, $y);
        $pdf->MultiCell(20, 5, 'Tan. Akhir Bulan (ha)', 1, 'C');
        $pdf->SetXY(160, $y);
        $pdf->MultiCell(20, 5, 'Produktifitas (ku/ha)', 1, 'C');
        $pdf->SetXY(180, $y);
        $pdf->Cell(20, 10, 'Produksi (ton)', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('');

        foreach ($luasTanam as $i => $lt) {
            $pdf->Cell(7,5,$i + 1,1,0,'C');
            $pdf->Cell(49,5,$lt->tanaman->nama,1,0);
            $pdf->Cell(23,5,$lt->tanaman_awal,1,0,'C');
            $pdf->Cell(15,5,$lt->sdg_menghasilkan,1,0,'C');
            $pdf->Cell(15,5,$lt->luas_rusak,1,0,'C');
            $pdf->Cell(21,5,$lt->ditambah,1,0,'C');
            $pdf->Cell(20,5,($lt->tanaman_awal - $lt->sdg_menghasilkan - $lt->luas_rusak + $lt->ditambah),1,0,'C');
            $pdf->Cell(20,5,$lt->produktifitas,1,0,'C');
            $pdf->Cell(20,5,$lt->produksi,1,0,'C');
            $pdf->Ln();
        }

        $pdf->Ln(10);

        // LAPORAN PETERNAKAN
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(70, 7, 'B. LAPORAN PETERNAKAN', $border, 1);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 10, 'No', 1, 0, 'C');
        $pdf->Cell(49, 10, 'Jenis Ternak', 1, 0, 'C');
        $pdf->Cell(23, 5, 'Populasi Awal', 1, 0, 'C');
        $pdf->SetXY(66, $y + 5);
        $pdf->Cell(12, 5, 'Jan', 1, 0, 'C');
        $pdf->Cell(11, 5, 'Bet', 1, 0, 'C');
        $pdf->SetXY(89, $y);
        $pdf->Cell(15, 5, 'Lahir', 1, 0,'C');
        $pdf->SetXY(89, $y + 5);
        $pdf->Cell(8, 5, 'Jan', 1, 0, 'C');
        $pdf->Cell(7, 5, 'Bet', 1, 0, 'C');
        $pdf->SetXY(104, $y);
        $pdf->Cell(15, 5, 'Dipotong', 1, 0,'C');
        $pdf->SetXY(104, $y + 5);
        $pdf->Cell(8, 5, 'Jan', 1, 0, 'C');
        $pdf->Cell(7, 5, 'Bet', 1, 0, 'C');
        $pdf->SetXY(119, $y);
        $pdf->Cell(21, 5, 'Mati', 1, 0, 'C');
        $pdf->SetXY(119, $y + 5);
        $pdf->Cell(11, 5, 'Jan', 1, 0, 'C');
        $pdf->Cell(10, 5, 'Bet', 1, 0, 'C');
        $pdf->SetXY(140, $y);
        $pdf->Cell(20, 5, 'Masuk', 1, 0, 'C');
        $pdf->SetXY(140, $y + 5);
        $pdf->Cell(10, 5, 'Jan', 1, 0, 'C');
        $pdf->Cell(10, 5, 'Bet', 1, 0, 'C');
        $pdf->SetXY(160, $y);
        $pdf->Cell(20, 5, 'Keluar', 1, 0, 'C');
        $pdf->SetXY(160, $y + 5);
        $pdf->Cell(10, 5, 'Jan', 1, 0, 'C');
        $pdf->Cell(10, 5, 'Bet', 1, 0, 'C');
        $pdf->SetXY(180, $y);
        $pdf->Cell(20, 5, 'Populasi Akhir', 1, 0, 'C');
        $pdf->SetXY(180, $y + 5);
        $pdf->Cell(10, 5, 'Jan', 1, 0, 'C');
        $pdf->Cell(10, 5, 'Bet', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('');

        $pdf->Cell(7,5,'1',1,0,'C');
        $pdf->Cell(49,5,'Sapi Potong',1,0);
        $pdf->Cell(12,5,'10',1,0,'C');
        $pdf->Cell(11,5,'10',1,0,'C');
        $pdf->Cell(8,5,'3',1,0,'C');
        $pdf->Cell(7,5,'3',1,0,'C');
        $pdf->Cell(8,5,'2',1,0,'C');
        $pdf->Cell(7,5,'2',1,0,'C');
        $pdf->Cell(11,5,'10',1,0,'C');
        $pdf->Cell(10,5,'10',1,0,'C');
        $pdf->Cell(10,5,'2',1,0,'C');
        $pdf->Cell(10,5,'2',1,0,'C');
        $pdf->Cell(10,5,'3',1,0,'C');
        $pdf->Cell(10,5,'3',1,0,'C');
        $pdf->Cell(10,5,'5',1,0,'C');
        $pdf->Cell(10,5,'5',1,0,'C');

        $pdf->Ln(10);

        // LUAS SERANGAN ORGANISME PENGGANGGU TANAMAN
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(70, 7, 'C. LUAS SERANGAN ORGANISME PENGGANGGU TANAMAN', $border, 1);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 10, 'No', 1, 0, 'C');
        $pdf->Cell(49, 10, 'Jenis Tanaman', 1, 0, 'C');
        $pdf->Cell(38, 10, 'Jenis OPT / Bencana', 1, 0, 'C');
        $pdf->MultiCell(22, 5, 'Luas Serangan (ha)', 1, 'C');
        $pdf->SetXY(126, $y);
        $pdf->Cell(74, 10, 'Upaya yang telah dilakukan', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('');

        $pdf->Cell(7, 5, '1', 1, 0, 'C');
        $pdf->Cell(49, 5, 'Padi', 1, 0);
        $pdf->Cell(38, 5, 'Hama', 1, 0);
        $pdf->Cell(22, 5, '5', 1, 0, 'C');
        $pdf->Cell(74, 5, 'Penyemprotan Anti Hama', 1, 0);
        $pdf->Ln();

        $pdf->Ln(10);
        $pdf->Cell(95, 5, 'Mengetahui', $border, 0, 'C');
        $pdf->Cell(95, 5, 'Ciawigebang, 20 November 2020', $border, 1, 'C');
        $pdf->Cell(95, 5, 'Kepala Desa Ciawigebang,', $border, 0, 'C');
        $pdf->Cell(95, 5, 'Kaur Ekbang,', $border, 1, 'C');
        $pdf->Cell(95, 15, '', $border, 0, 'C');
        $pdf->Cell(95, 15, '', $border, 1, 'C');
        $pdf->Cell(95, 5, $request->kepala_desa ?? '...............', $border, 0, 'C');
        $pdf->Cell(95, 5, $request->kaur_ekbang ?? '...............', $border, 1, 'C');

        // PAGE 2
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 7, 'LAPORAN TRIWULAN KAUR EKBANG', $border, 1, 'C');       
        $pdf->SetX(70);
        $pdf->SetFont('');
        $pdf->Cell(30, 5, 'TRIWULAN', $border, 0);
        $pdf->Cell(5, 5, ':', $border, 0);
        $pdf->Cell(30, 5, $kuartal->section, $border, 0);
        $pdf->Ln();
        $pdf->SetX(70);
        $pdf->Cell(30, 5, 'DESA', $border, 0);
        $pdf->Cell(5, 5, ':', $border, 0);
        $pdf->Cell(30, 5, 'Ciawigebang', $border, 0);
        $pdf->Ln(10);
        
        $pdf->SetXY(150, 25);
        $pdf->SetFont('Arial','B', 14);
        $pdf->Cell(50, 10, 'ASLI (EKBANG)', 1, 1, 'C');

        // LAPORAN TANAMAN BUAH-BUAHAN (satuan dalam pohon)
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(70, 7, 'A. LAPORAN TANAMAN BUAH-BUAHAN (satuan dalam pohon)', $border, 1);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 10, 'No', 1, 0, 'C');
        $pdf->Cell(49, 10, 'Jenis Tanaman', 1, 0, 'C');
        $pdf->MultiCell(21, 5, 'Tan. Triwulan Lalu', 1, 'C');
        $pdf->SetXY(87, $y);
        $pdf->MultiCell(16, 5, 'Tanaman dibongkar', 1, 'C');
        $pdf->SetXY(103, $y);
        $pdf->MultiCell(15, 5, 'Tambah Tanam', 1,'C');
        $pdf->SetXY(118, $y);
        $pdf->MultiCell(21, 5, 'Tan. Akhir Triwulan', 1, 'C');
        $pdf->SetXY(139, $y);
        $pdf->MultiCell(21, 5, 'Tan. Belum Menghasilkan', 1, 'C');
        $pdf->SetXY(160, $y);
        $pdf->MultiCell(21, 5, 'Tan. Sedang Menghasilkan', 1, 'C');
        $pdf->SetXY(181, $y);
        $pdf->Cell(19, 10, 'Produksi (ku)', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('');

        foreach ($tanamanBuah as $i => $tb) {
            $pdf->Cell(7, 5, $i + 1, 1, 0, 'C');
            $pdf->Cell(49, 5, $tb->tanaman->nama, 1, 0);
            $pdf->Cell(21, 5, $tb->tanaman_awal, 1, 0,'C');
            $pdf->Cell(16, 5, $tb->dibongkar, 1, 0,'C');
            $pdf->Cell(15, 5, $tb->ditambah, 1,0,'C');
            $pdf->Cell(21, 5, ($tb->tanaman_awal - $tb->dibongkar + $tb->ditambah), 1, 0,'C');
            $pdf->Cell(21, 5, $tb->blm_menghasilkan, 1, 0,'C');
            $pdf->Cell(21, 5, $tb->sdg_menghasilkan, 1, 0,'C');
            $pdf->Cell(19, 5, $tb->produksi, 1, 0,'C');
            $pdf->Ln();
        }

        $pdf->Ln(10);

        // LAPORAN TANAMAN OBAT-OBATAN (satuan dalam m2)
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(70, 7, 'B. LAPORAN TANAMAN OBAT-OBATAN (satuan dalam m2)', $border, 1);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 15, 'No', 1, 0, 'C');
        $pdf->Cell(49, 15, 'Jenis Tanaman', 1, 0, 'C');
        $pdf->SetXY(66, $y);
        $pdf->MultiCell(21, 5, 'Luas Tanaman Triwulan Lalu', 1, 'C');
        $pdf->SetXY(87, $y);
        $pdf->Cell(37, 5, 'Luas Panen', 1, 0, 'C');
        $pdf->SetXY(87, $y + 5);
        $pdf->MultiCell(21, 5, 'Habis dibongkar', 1, 'C');
        $pdf->SetXY(108, $y + 5);
        $pdf->MultiCell(16, 5, 'Belum habis', 1, 'C');
        $pdf->SetXY(124, $y);
        $pdf->MultiCell(15, 5, 'Luas Rusak (puso)', 1,'C');
        $pdf->SetXY(139, $y);
        $pdf->MultiCell(21, 5, 'Luas Tanaman Baru', 1, 'C');
        $pdf->SetXY(160, $y);
        $pdf->MultiCell(21, 5, 'Luas Tanaman Akhir', 1, 'C');
        $pdf->SetXY(181, $y);
        $pdf->Cell(19, 15, 'Produksi (kg)', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('');

        foreach ($tanamanObat as $i => $to) {
            $pdf->Cell(7, 5, $i + 1, 1, 0, 'C');
            $pdf->Cell(49, 5, $to->tanaman->nama, 1, 0);
            $pdf->Cell(21, 5, $to->tanaman_awal, 1, 0, 'C');
            $pdf->Cell(21, 5, $to->dibongkar, 1, 0, 'C');
            $pdf->Cell(16, 5, $to->sdg_menghasilkan, 1, 0, 'C');
            $pdf->Cell(15, 5, $to->luas_rusak, 1, 0, 'C');
            $pdf->Cell(21, 5, $to->ditambah, 1, 0, 'C');
            $pdf->Cell(21, 5, ($to->tanaman_awal - $to->dibongkar - $to->luas_rusak + $to->ditambah), 1, 0, 'C');
            $pdf->Cell(19, 5, $to->produksi, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Ln(10);

        // LAPORAN TANAMAN PERKEBUNAN
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(70, 7, 'C. LAPORAN TANAMAN PERKEBUNAN', $border, 1);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 15, 'No', 1, 0, 'C');
        $pdf->Cell(49, 15, 'Jenis Tanaman', 1, 0, 'C');
        $pdf->SetXY(66, $y);
        $pdf->MultiCell(21, 5, 'Luas Tanaman Triwulan Lalu', 1, 'C');
        $pdf->SetXY(87, $y);
        $pdf->MultiCell(21, 5, 'Tanaman dibongkar (pohon)', 1, 'C');
        $pdf->SetXY(108, $y);
        $pdf->MultiCell(16, 5, 'Tambah Tanam (pohon)', 1, 'C');
        $pdf->SetXY(124, $y);
        $pdf->MultiCell(15, 5, 'Tanaman Akhir Triwulan', 1,'C');
        $pdf->SetXY(139, $y);
        $pdf->MultiCell(21, 5, 'Tanaman Belum Menghasilkan', 1, 'C');
        $pdf->SetXY(160, $y);
        $pdf->MultiCell(21, 5, 'Tanaman Sedang Menghasilkan', 1, 'C');
        $pdf->SetXY(181, $y);
        $pdf->Cell(19, 15, 'Produksi (ku)', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('');

        foreach ($tanamanKebun as $i => $tk) {
            $pdf->Cell(7, 5, $i + 1, 1, 0, 'C');
            $pdf->Cell(49, 5, $tk->tanaman->nama, 1, 0);
            $pdf->Cell(21, 5, $tk->tanaman_awal, 1, 0, 'C');
            $pdf->Cell(21, 5, $tk->dibongkar, 1, 0, 'C');
            $pdf->Cell(16, 5, $tk->ditambah, 1, 0, 'C');
            $pdf->Cell(15, 5, ($tk->tanaman_awal - $tk->dibongkar + $tk->ditambah), 1, 0, 'C');
            $pdf->Cell(21, 5, $tk->blm_menghasilkan, 1, 0, 'C');
            $pdf->Cell(21, 5, $tk->sdg_menghasilkan, 1, 0, 'C');
            $pdf->Cell(19, 5, $tk->produksi, 1, 0, 'C');
            $pdf->Ln();
        }

         
        $pdf->Output();
        exit;
    }

    public function kepemilikanLahanPertanian()
    {
        $quarters = Quarter::all();

        return view('laporan.kepemilikan-lahan-pertanian', compact('quarters'));
    }

    public function kepemilikanLahanPertanianPDF(LaporanKepemilikanLahanPertanianRequest $request)
    {
        $border = 0;

        $kepemilikanLahan = KepemilikanLahan::with('quarter', 'kelompokTani')
            ->where('tahun', $request->tahun)
            ->where('kuartal_id', $request->kuartal_id)
            ->get();

        $pdf = new Fpdf;
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 7, 'DATA PEMILIK LAHAN PERTANIAN', $border, 1, 'C');       
        $pdf->SetFont('');
        $pdf->Cell(30, 5, 'Kecamatan', $border, 0);
        $pdf->Cell(5, 5, ':', $border, 0);
        $pdf->Cell(30, 5, 'Ciawigebang', $border, 0);
        $pdf->Ln();
        $pdf->Cell(30, 5, 'Desa', $border, 0);
        $pdf->Cell(5, 5, ':', $border, 0);
        $pdf->Cell(30, 5, 'Ciawigebang', $border, 0);
        $pdf->Ln(10);

        // LAPORAN LUAS TANAM DAN PANEN
        $y = $pdf->GetY();
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(7, 15, 'No', 1, 0, 'C');
        $pdf->Cell(35, 15, 'Nama Blok', 1, 0, 'C');
        $pdf->Cell(40, 15, 'Nama Pemilik', 1, 0, 'C');
        $pdf->Cell(32, 5, 'Luas Lahan (ha)', 1, 0, 'C');
        $pdf->SetXY(92, $y + 5);
        $pdf->Cell(15, 10, 'Sawah', 1, 0, 'C');
        $pdf->MultiCell(17, 5, 'Rencana LP2B', 1, 'C');
        $pdf->SetXY(124, $y);
        $pdf->Cell(40, 15, 'Alamat Pemilik', 1, 0, 'C');
        $pdf->Cell(40, 15, 'Nama Kelompok Tani', 1, 0, 'C');
        $pdf->Ln();
        
        $pdf->SetFont('');
        
        $totalSawah = 0.0;
        $totalRencana = 0.0;
        
        foreach ($kepemilikanLahan as $i => $kl) {
            $totalSawah += $kl->luas_sawah;
            $totalRencana += $kl->luas_rencana;
            $pdf->Cell(7, 5, $i + 1, 1, 0, 'C');
            $pdf->Cell(35, 5, $kl->blok, 1, 0);
            $pdf->Cell(40, 5, $kl->pemilik, 1, 0);
            $pdf->Cell(15, 5, $kl->luas_sawah, 1, 0, 'C');
            $pdf->Cell(17, 5, $kl->luas_rencana, 1, 0, 'C');
            $pdf->Cell(40, 5, $kl->alamat, 1, 0, 'C');
            $pdf->Cell(40, 5, $kl->kelompokTani->nama, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(82, 7, 'Jumlah', 1, 0, 'R');
        $pdf->Cell(15, 7, $totalSawah, 1, 0, 'C');
        $pdf->Cell(17, 7, $totalRencana, 1, 0, 'C');
        $pdf->Cell(80, 7, '', 1, 0, 'C');
        $pdf->Ln();

        $pdf->Output();
        exit;
    }

    public function kepemilikanHewanTernak()
    {
        $quarters = Quarter::all();

        return view('laporan.kepemilikan-hewan-ternak', compact('quarters'));
    }

    public function kepemilikanHewanTernakPDF(LaporanKepemilikanHewanTernakRequest $request)
    {
        $border = 0;

        $kepemilikanHewan = JumlahKepemilikanHewan::with('hewan', 'quarter')
            ->where('kuartal_id', $request->kuartal_id)
            ->where('tahun', $request->tahun)
            ->get();

        $pdf = new Fpdf;
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 7, 'DATA PEMILIK HEWAN TERNAK', $border, 1, 'C');       
        $pdf->SetFont('');
        $pdf->Cell(30, 5, 'Kecamatan', $border, 0);
        $pdf->Cell(5, 5, ':', $border, 0);
        $pdf->Cell(30, 5, 'Ciawigebang', $border, 0);
        $pdf->Ln();
        $pdf->Cell(30, 5, 'Desa', $border, 0);
        $pdf->Cell(5, 5, ':', $border, 0);
        $pdf->Cell(30, 5, 'Ciawigebang', $border, 0);
        $pdf->Ln(10);

        $y = $pdf->GetY();
        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nama Blok', 1, 0, 'C');
        $pdf->Cell(45, 10, 'Nama Pemilik', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Jenis Hewan', 1, 0, 'C');
        $pdf->Cell(32, 10, 'Jumlah', 1, 0, 'C');
        $pdf->Ln();
        
        $pdf->SetFont('');

        foreach ($kepemilikanHewan as $i => $kh) {
            $pdf->Cell(10, 10, $i + 1, 1, 0, 'C');
            $pdf->Cell(40, 10, $kh->blok, 1, 0, 'C');
            $pdf->Cell(45, 10, $kh->pemilik, 1, 0, 'C');
            $pdf->Cell(40, 10, $kh->hewan->nama, 1, 0, 'C');
            $pdf->Cell(32, 10, $kh->jumlah, 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output();
        exit;
    }
}
