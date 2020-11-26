@extends('layouts.dashboard')
@section('heading', config('app.name'))

@section('content')
@if(session()->has('logged'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-check"></i> {{ session()->get('logged') }}</h5>
  Selamat Datang, {{ auth()->user()->name }}.
</div>
@endif

<div class="row">
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-6">
        <div class="info-box bg-gradient-info">
          <span class="info-box-icon"><i class="fas fa-paw"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Populasi Hewan</span>
            <span class="info-box-number">{{ $qtyHewan }} dari {{ $countHewan }}</span>
            <div class="progress">
              @php((int) $percentHewan = $qtyHewan / $countHewan * 100)
              <div class="progress-bar" style="width: {{ $percentHewan }}%"></div>
            </div>
            <span class="progress-description">
              Data Telah Terisi
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="info-box bg-gradient-success">
          <span class="info-box-icon"><i class="fas fa-leaf"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Luas Lahan Tanam</span>
            <span class="info-box-number">{{ $qtyLuasLahan }} dari {{ $countSawah }}</span>
            <div class="progress">
              @php((int) $percentLuasLahan = $qtyLuasLahan / $countSawah * 100)
              <div class="progress-bar" style="width: {{ $percentLuasLahan }}%"></div>
            </div>
            <span class="progress-description">
              Data Telah Terisi
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="info-box bg-gradient-warning">
          <span class="info-box-icon"><i class="fas fa-seedling"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Jumlah Tanaman</span>
            <span class="info-box-number">{{ $qtyTanaman }} dari {{ $countTanaman }}</span>
            <div class="progress">
              @php((int) $percentTanaman = $qtyTanaman / $countTanaman * 100)
              <div class="progress-bar" style="width: {{ $percentTanaman }}%"></div>
            </div>
            <span class="progress-description">
              Data Telah Terisi
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="info-box bg-gradient-danger">
          <span class="info-box-icon"><i class="fas fa-border-style"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Kepemilikan Lahan</span>
            <span class="info-box-number">{{ $qtyKepemilikanLahan }}</span>
            <div class="progress" style="visibility: hidden">
              @php((int) $percentTanaman = $qtyTanaman / $countTanaman * 100)
              <div class="progress-bar" style="width: {{ $percentTanaman }}%"></div>
            </div>
            <span class="progress-description">
              Data Telah Terisi
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">Luas Lahan Pertanian <small class="text-muted">kelompok tani</small></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Kelompok Tani</th>
                    <th>Sawah <small class="text-muted">(ha)</small></th>
                    <th>Rencana <small class="text-muted">(ha)</small></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kepemilikanLahanPerKelompokTani as $kl)
                  <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $kl->kelompokTani->nama }}</td>
                    <td>{{ $kl->total_luas_sawah }}</td>
                    <td>{{ $kl->total_luas_rencana }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card card-info card-outline">
      <div class="card-header">
        <h3 class="card-title">Tentang Sistem Pendataan Pertanian</h3>
      </div>
      <div class="card-body">
        <div id="accordion">
          <div class="card card-default">
            <div class="card-header">
              <h4 class="card-title">
                <a class="text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  Sistem Pendataan Pertanian Desa Ciawigebang
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in show">
              <div class="card-body">
                <strong>Sistem Pendataan Pertanian Desa Ciawigebang</strong> adalah suatu sistem yang berfungsi untuk mendata pertanian di Desa Ciawigebang, di mana nantinya akan membantu dalam hal pelaporan data pertanian Desa Ciawigebang.
              </div>
            </div>
          </div>
          <div class="card card-default">
            <div class="card-header">
              <h4 class="card-title">
                <a class="text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                  Cara Pengisian Data
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
              <div class="card-body">
                <ol>
                  <li>Pada bilah kiri terdapat berbagai macam menu yang dapat dipilih</li>
                  <li>Silahkan pilih menu, apabila hendak mengisi data</li>
                  <li>Ketika menu telah dipilih, sebelah kanan atas tabel terdapat tombol untuk tambah data</li>
                  <li>Klik tombol tersebut untuk menambah data</li>
                  <li>Klik tombol <strong>Simpan</strong> untuk menyimpan</li>
                </ol>
              </div>
            </div>
          </div>
          <div class="card card-default">
            <div class="card-header">
              <h4 class="card-title">
                <a class="text-dark" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                  Cara Mengubah Data Akun
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
              <div class="card-body">
                <ol>
                  <li>Pada pojok kanan atas layar, terdapat ikon orang (user).</li>
                  <li>Silahkan klik ikon tersebut.</li>
                  <li>Pilih <strong>Edit Profil</strong></li>
                  <li>Lalu ubah data akun.</li>
                  <li>Klik <strong>Perbaharui</strong> untuk menyimpan data</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  
  
</div>
@endsection
