@extends('layouts.dashboard')
@section('title', 'Kondisi Umum :: '.config('app.name'))
@section('heading', 'Kondisi Umum')
    
@section('content')
<div class="card">
  <div class="card-header">
    <h5 class="card-title">Kondisi Umum pada tahun <mark>{{ now()->format('Y') }}</mark></h5>
    <div class="card-tools">
      <a href="{{ route('profil-irigasi.index') }}" class="btn btn-tool"><i class="fas fa-times"></i></a>
    </div>
  </div>
  <form id="form">
    @method('put')
    <div class="card-body">

      <h2>Umum</h2>
      
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="nama_daerah_irigasi">Nama Daerah Irigasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="nama_daerah_irigasi" id="nama_daerah_irigasi">
            <small class="text-danger" id="error-nama_daerah_irigasi"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="nama_kantor_pengelola">Nama Kantor Pengelola <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="nama_kantor_pengelola" id="nama_kantor_pengelola">
            <small class="text-danger" id="error-nama_kantor_pengelola"></small>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="luas_areal_baku">Luas Areal Baku <span class="text-muted">(ha)</span> <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="luas_areal_baku" id="luas_areal_baku">
            <small class="text-danger" id="error-luas_areal_baku"></small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="luas_potensial">Luas Potensial <span class="text-muted">(ha)</span> <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="luas_potensial" id="luas_potensial">
            <small class="text-danger" id="error-luas_potensial"></small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="luas_fungsional">Luas Fungsional <span class="text-muted">(ha)</span> <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="luas_fungsional" id="luas_fungsional">
            <small class="text-danger" id="error-luas_fungsional"></small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="kewenangan_operasional">Kewenangan Operasional <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="kewenangan_operasional" id="kewenangan_operasional">
            <small class="text-danger" id="error-kewenangan_operasional"></small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="kewenangan_pemeliharaan">Kewenangan Pemeliharaan <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="kewenangan_pemeliharaan" id="kewenangan_pemeliharaan">
            <small class="text-danger" id="error-kewenangan_pemeliharaan"></small>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="kewenangan_rehabilitasi">Kewenangan Rehabilitasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="kewenangan_rehabilitasi" id="kewenangan_rehabilitasi">
            <small class="text-danger" id="error-kewenangan_rehabilitasi"></small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label>Nama Sumber Air <span class="text-danger">*</span></label><br>
          <div id="input-sumber-air"></div>
          <button class="btn btn-sm btn-secondary" type="button" id="button-add-sumber-air"><i class="fas fa-plus"></i> Tambah sumber air</button>
          <br><small class="text-danger" id="error-nama_sumber_air"></small>
        </div>
      </div>
      
      <div class="form-group mt-3">
        <label for="nama_sungai">Nama Sungai <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="nama_sungai" id="nama_sungai">
        <small class="text-danger" id="error-nama_sungai"></small>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label>Lokasi Bendung / Bangunan Pengambil (intake) <span class="text-danger">*</span></label><br>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <span for="lokasi_bendung_desa">Desa <span class="text-danger">*</span></span>
                <input type="text" class="form-control form-control-sm" name="lokasi_bendung_desa" id="lokasi_bendung_desa">
                <small class="text-danger" id="error-lokasi_bendung_desa"></small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <span for="lokasi_bendung_kecamatan">Kecamatan <span class="text-danger">*</span></span>
                <input type="text" class="form-control form-control-sm" name="lokasi_bendung_kecamatan" id="lokasi_bendung_kecamatan">
                <small class="text-danger" id="error-lokasi_bendung_kecamatan"></small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">
      <h2>Daerah Irigasi</h2>

      <div class="row mt-3">
        <div class="col-md-12">
          <label>Posisi di sungai</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="posisi_di_daerah_irigasi[]" id="posisi_di_sungai_1" value="hulu">
            <label class="form-check-label" for="posisi_di_sungai_1">Hulu</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="posisi_di_daerah_irigasi[]" id="posisi_di_sungai_2" value="tengah">
            <label class="form-check-label" for="posisi_di_sungai_2">Tengah</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="posisi_di_daerah_irigasi[]" id="posisi_di_sungai_3" value="hilir">
            <label class="form-check-label" for="posisi_di_sungai_3">Hilir</label>
          </div><br>
          <small class="text-danger" id="error-posisi_di_daerah_irigasi"></small>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <label>Nama Daerah Irigasi lain</label><br>
        </div>
        <div class="col-md-6">
          <span>Hulu</span><br>
          <div id="input-nama-hulu-daerah-irigasi"></div>
          <button class="btn btn-sm btn-secondary" type="button" id="button-add-nama-hulu-daerah-irigasi"><i class="fas fa-plus"></i> Tambah Nama Hulu</button>
          <br><small class="text-danger" id="error-nama_hulu_daerah_irigasi"></small>
        </div>
        <div class="col-md-6">
          <span>Hilir</span><br>
          <div id="input-nama-hilir-daerah-irigasi"></div>
          <button class="btn btn-sm btn-secondary" type="button" id="button-add-nama-hilir-daerah-irigasi"><i class="fas fa-plus"></i> Tambah Nama Hilir</button>
          <br><small class="text-danger" id="error-nama_hilir_daerah_irigasi"></small>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <label>Lokasi Pelayanan</label><br>
          <div id="input-lokasi-pelayanan-daerah-irigasi"></div>
          <button class="btn btn-sm btn-secondary" type="button" data-idx="0" id="button-add-lokasi-pelayanan-daerah-irigasi"><i class="fas fa-plus"></i> Tambah Lokasi</button>
          <br><small class="text-danger" id="error-lokasi_pelayanan_daerah_irigasi"></small>
        </div>
      </div>

      <hr class="my-4">
      <h2>Saluran Sekunder</h2>

      <div class="row mt-3">
        <div class="col-md-12">
          <label>Posisi di sungai</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="posisi_di_saluran_sekunder[]" id="posisi_di_saluran_sekunder_1" value="hulu">
            <label class="form-check-label" for="posisi_di_saluran_sekunder_1">Hulu</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="posisi_di_saluran_sekunder[]" id="posisi_di_saluran_sekunder_2" value="tengah">
            <label class="form-check-label" for="posisi_di_saluran_sekunder_2">Tengah</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="posisi_di_saluran_sekunder[]" id="posisi_di_saluran_sekunder_3" value="hilir">
            <label class="form-check-label" for="posisi_di_saluran_sekunder_3">Hilir</label>
          </div><br>
          <small class="text-danger" id="error-posisi_di_saluran_sekunder"></small>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <label>Nama Saluran Sekunder lain</label><br>
        </div>
        <div class="col-md-4">
          <span>Hulu</span><br>
          <div id="input-nama-hulu-saluran-sekunder"></div>
          <button class="btn btn-sm btn-secondary" type="button" id="button-add-nama-hulu-saluran-sekunder"><i class="fas fa-plus"></i> Tambah Nama Hulu</button>
          <br><small class="text-danger" id="error-nama_hulu_saluran_sekunder"></small>
        </div>
        <div class="col-md-4">
          <span>Middle</span><br>
          <div id="input-nama-middle-saluran-sekunder"></div>
          <button class="btn btn-sm btn-secondary" type="button" id="button-add-nama-middle-saluran-sekunder"><i class="fas fa-plus"></i> Tambah Nama Middle</button>
          <br><small class="text-danger" id="error-nama_middle_saluran_sekunder"></small>
        </div>
        <div class="col-md-4">
          <span>Hilir</span><br>
          <div id="input-nama-hilir-saluran-sekunder"></div>
          <button class="btn btn-sm btn-secondary" type="button" id="button-add-nama-hilir-saluran-sekunder"><i class="fas fa-plus"></i> Tambah Nama Hilir</button>
          <br><small class="text-danger" id="error-nama_hilir_saluran_sekunder"></small>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <label>Lokasi Pelayanan</label><br>
          <div id="input-lokasi-pelayanan-saluran-sekunder"></div>
          <button class="btn btn-sm btn-secondary" type="button" data-idx="0" id="button-add-lokasi-pelayanan-saluran-sekunder"><i class="fas fa-plus"></i> Tambah Lokasi</button>
          <br><small class="text-danger" id="error-lokasi_pelayanan_saluran_sekunder"></small>
        </div>
      </div>

      <hr class="my-4">
      <h2>Petani</h2>

      <div class="row mt-3">
        <div class="col-md-12">
          <label>Jumlah kelompok</label><br>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <span>P3A <span class="text-muted">(unit)</span></span><br>
                <input type="text" name="jml_p3a" id="jml_p3a" class="form-control form-control-sm">
                <small class="text-danger" id="error-jml_p3a"></small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <span>GP3A <span class="text-muted">(unit)</span></span><br>
                <input type="text" name="jml_gp3a" id="jml_gp3a" class="form-control form-control-sm">
                <small class="text-danger" id="error-jml_gp3a"></small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <span>IP3A <span class="text-muted">(unit)</span></span><br>
                <input type="text" name="jml_ip3a" id="jml_ip3a" class="form-control form-control-sm">
                <small class="text-danger" id="error-jml_ip3a"></small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <span>Poktan <span class="text-muted">(unit)</span></span><br>
                <input type="text" name="jml_poktan" id="jml_poktan" class="form-control form-control-sm">
                <small class="text-danger" id="error-jml_poktan"></small>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <span>Gapoktan <span class="text-muted">(unit)</span></span><br>
                <input type="text" name="jml_gapoktan" id="jml_gapoktan" class="form-control form-control-sm">
                <small class="text-danger" id="error-jml_gapoktan"></small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label>Jumlah petani</label><br>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <span>Laki-laki <span class="text-muted">(orang)</span></span><br>
                <input type="text" name="jml_petani_laki_laki" id="jml_petani_laki_laki" class="form-control form-control-sm">
                <small class="text-danger" id="error-jml_petani_laki_laki"></small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <span>Perempuan <span class="text-muted">(orang)</span></span><br>
                <input type="text" name="jml_petani_perempuan" id="jml_petani_perempuan" class="form-control form-control-sm">
                <small class="text-danger" id="error-jml_petani_perempuan"></small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group mt-3">
        <label for="tgl_survei">Tanggal Survei <span class="text-danger">*</span></label>
        <input type="date" name="tgl_survei" class="form-control form-control-sm w-25" id="tgl_survei">
        <small class="text-danger" id="error-tgl_survei"></small>
      </div>


    </div>
    <div class="card-footer">
      <span class="text-muted"><strong class="text-danger">*</strong> Data wajib diisi.</span>
      <div class="float-right">
        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Simpan</button> 
      </div>
    </div>
  </form>
</div>
@endsection

@section('js')
<script>
  let buttonAddSumberAir = document.getElementById('button-add-sumber-air');
  buttonAddSumberAir.addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('input-sumber-air').insertAdjacentHTML('beforeend', `
      <div class="input-group mb-3 w-50">
        <input type="text" class="form-control form-control-sm" name="nama_sumber_air[]" required>
        <div class="input-group-append">
          <button class="btn btn-sm btn-danger" type="button" onclick="handleRemoveParent(this)"><i class="fas fa-times"></i> Hapus</button>
        </div>
      </div>
    `);
  });

  let buttonAddNamaHuluDaerahIrigasi = document.getElementById('button-add-nama-hulu-daerah-irigasi');
  buttonAddNamaHuluDaerahIrigasi.addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('input-nama-hulu-daerah-irigasi').insertAdjacentHTML('beforeend', `
      <div class="input-group mb-3">
        <input type="text" class="form-control form-control-sm" name="nama_hulu_daerah_irigasi[]" required>
        <div class="input-group-append">
          <button class="btn btn-sm btn-danger" type="button" onclick="handleRemoveParent(this)"><i class="fas fa-times"></i> Hapus</button>
        </div>
      </div>
    `);
  });

  let buttonAddNamaHilirDaerahIrigasi = document.getElementById('button-add-nama-hilir-daerah-irigasi');
  buttonAddNamaHilirDaerahIrigasi.addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('input-nama-hilir-daerah-irigasi').insertAdjacentHTML('beforeend', `
      <div class="input-group mb-3">
        <input type="text" class="form-control form-control-sm" name="nama_hilir_daerah_irigasi[]" required>
        <div class="input-group-append">
          <button class="btn btn-sm btn-danger" type="button" onclick="handleRemoveParent(this)"><i class="fas fa-times"></i> Hapus</button>
        </div>
      </div>
    `);
  });

  let buttonAddLokasiPelayananDaerahIrigasi = document.getElementById('button-add-lokasi-pelayanan-daerah-irigasi');
  buttonAddLokasiPelayananDaerahIrigasi.addEventListener('click', function(event) {
    event.preventDefault();
    let idx = event.target.getAttribute('data-idx');
    document.getElementById('input-lokasi-pelayanan-daerah-irigasi').insertAdjacentHTML('beforeend', `
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Desa <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="lokasi_pelayanan_daerah_irigasi[${idx}][desa]" required>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Kecamatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="lokasi_pelayanan_daerah_irigasi[${idx}][kecamatan]" required>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Luas Areal <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="lokasi_pelayanan_daerah_irigasi[${idx}][luas]" required>
          </div>
        </div>
        <div class="col-md-3 pt-3">
          <button class="btn btn-sm btn-danger" type="button" onclick="handleRemoveParent(this)"><i class="fas fa-times"></i> Hapus</button>
        </div>
      </div>
    `);
    event.target.setAttribute('data-idx', ++idx);
  });

  let buttonAddNamaHuluSaluranSekunder = document.getElementById('button-add-nama-hulu-saluran-sekunder');
  buttonAddNamaHuluSaluranSekunder.addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('input-nama-hulu-saluran-sekunder').insertAdjacentHTML('beforeend', `
      <div class="input-group mb-3">
        <input type="text" class="form-control form-control-sm" name="nama_hulu_saluran_sekunder[]" required>
        <div class="input-group-append">
          <button class="btn btn-sm btn-danger" type="button" onclick="handleRemoveParent(this)"><i class="fas fa-times"></i> Hapus</button>
        </div>
      </div>
    `);
  });

  let buttonAddNamaMiddleSaluranSekunder = document.getElementById('button-add-nama-middle-saluran-sekunder');
  buttonAddNamaMiddleSaluranSekunder.addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('input-nama-middle-saluran-sekunder').insertAdjacentHTML('beforeend', `
      <div class="input-group mb-3">
        <input type="text" class="form-control form-control-sm" name="nama_middle_saluran_sekunder[]" required>
        <div class="input-group-append">
          <button class="btn btn-sm btn-danger" type="button" onclick="handleRemoveParent(this)"><i class="fas fa-times"></i> Hapus</button>
        </div>
      </div>
    `);
  });

  let buttonAddNamaHilirSaluranSekunder = document.getElementById('button-add-nama-hilir-saluran-sekunder');
  buttonAddNamaHilirSaluranSekunder.addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('input-nama-hilir-saluran-sekunder').insertAdjacentHTML('beforeend', `
      <div class="input-group mb-3">
        <input type="text" class="form-control form-control-sm" name="nama_hilir_saluran_sekunder[]" required>
        <div class="input-group-append">
          <button class="btn btn-sm btn-danger" type="button" onclick="handleRemoveParent(this)"><i class="fas fa-times"></i> Hapus</button>
        </div>
      </div>
    `);
  });

  let buttonAddLokasiPelayananSaluranSekunder = document.getElementById('button-add-lokasi-pelayanan-saluran-sekunder');
  buttonAddLokasiPelayananSaluranSekunder.addEventListener('click', function(event) {
    event.preventDefault();
    let idx = event.target.getAttribute('data-idx');
    document.getElementById('input-lokasi-pelayanan-saluran-sekunder').insertAdjacentHTML('beforeend', `
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Desa <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="lokasi_pelayanan_saluran_sekunder[${idx}][desa]" required>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Kecamatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="lokasi_pelayanan_saluran_sekunder[${idx}][kecamatan]" required>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Luas Areal <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm" name="lokasi_pelayanan_saluran_sekunder[${idx}][luas]" required>
          </div>
        </div>
        <div class="col-md-3 pt-3">
          <button class="btn btn-sm btn-danger" type="button" onclick="handleRemoveParent(this)"><i class="fas fa-times"></i> Hapus</button>
        </div>
      </div>
    `);
    event.target.setAttribute('data-idx', ++idx);
  });

  function handleRemoveParent(event) {
    event.parentElement.parentElement.remove();
  }

  function handleOnSubmit(event) {
    event.preventDefault();

    removeClassNameByClass('form-control', 'is-invalid');
    removeInnerHTMLByIds([
      'nama_daerah_irigasi',
      'nama_kantor_pengelola',
      'luas_areal_baku',
      'luas_potensial',
      'luas_fungsional',
      'kewenangan_operasional',
      'kewenangan_pemeliharaan',
      'kewenangan_rehabilitasi',
      'nama_sumber_air',
      'nama_sungai',
      'lokasi_bendung_desa',
      'lokasi_bendung_kecamatan',
      'posisi_di_daerah_irigasi',
      'nama_hulu_daerah_irigasi',
      'nama_hilir_daerah_irigasi',
      'lokasi_pelayanan_daerah_irigasi',
      'posisi_di_saluran_sekunder',
      'nama_hulu_saluran_sekunder',
      'nama_middle_saluran_sekunder',
      'nama_hilir_saluran_sekunder',
      'lokasi_pelayanan_saluran_sekunder',
      'jml_p3a',
      'jml_gp3a',
      'jml_ip3a',
      'jml_poktan',
      'jml_gapoktan',
      'jml_petani_laki_laki',
      'jml_petani_perempuan',
      'tgl_survei',
    ], true);

    let method = 'post';
    let url = '{{ route('profil-irigasi.kondisi-umum.update') }}';

    Swal.fire({
      title: 'Simpan data?',
      text: 'Pastikan semua data telah benar.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Simpan',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        fetch(url, {
          headers,
          method,
          body: new FormData(event.target),
        })
        .then(res => {
          if (res.status !== 200) {
            Swal.fire(
              'Gagal Disimpan!',
              'Pastikan data yang anda isi benar dan valid.',
              'error'
            );
          }
          return res.json();
        })
        .then(data => {
          console.log(data);

          if (data.errors !== undefined) {
            for (const [key, value] of Object.entries(data.errors)) {
              document.getElementById(`error-${key}`).innerHTML = value;
              if (document.getElementById(key)) {
                document.getElementById(key).classList.add('is-invalid');
              }
            }
          }

          if (data.status) {
            Swal.fire({
              title: 'Sukses!',
              text: 'Selamat, data anda telah berhasil disimpan.',
              icon: 'success',
              onClose: () => {
                document.getElementById('password_old').value = '';
                document.getElementById('password').value = '';
              }
            });
          } else {
            console.log(data);
            Swal.fire({
              title: 'Simpan Data Gagal!',
              text: data.msg ?? 'Terjadi kesalahan pada saat menyimpan data.',
              icon: 'error',
            });
          }
        })
        .catch(err => console.log(err));
      },
      allowOutsideClick: () => !Swal.isLoading() 
    });
  }

  let form = document.getElementById('form');
  form.addEventListener('submit', handleOnSubmit);
</script>
@endsection
