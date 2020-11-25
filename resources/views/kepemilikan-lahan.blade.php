@extends('layouts.dashboard')
@section('title', 'Kepemilikan Lahan Pertanian :: '. config('app.name'))
@section('heading', 'Kepemilikan Lahan Pertanian')

@section('css')
<style>
  th, td { white-space: nowrap; }
</style>
@endsection

@section('content')
<div class="card card-outline card-primary" id="card-submit" style="display: none">
  <div class="card-header">
    <h5 class="card-title" id="card-title">Tambah Kepemilikan Lahan</h5>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  <form id="form" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" class="form-control">
    <input type="hidden" name="_method" id="_method" class="form-control">
    <div class="card-body">
      @can('kepemilikan_lahan_quarter')
      <div class="form-group row">
        <label for="tahun" class="col-md-3 col-form-label">Tahun</label>
        <div class="col-md-9">
          <input type="text" name="tahun" class="form-control form-control-sm w-25" id="tahun">
          <small class="text-danger" id="error-tahun"></small>
          <div><small class="text-muted">Jika kosong maka akan mengikuti tahun saat ini.</small></div>
        </div>
      </div>
      <div class="form-group row">
        <label for="kuartal_id" class="col-md-3 col-form-label">Kuartal</label>
        <div class="col-md-9">
          <select name="kuartal_id" id="kuartal_id" class="form-control select2bs4 form-control-sm" style="width: 25%">
            <option value="">--- Pilih kuartal ---</option>
            @foreach ($quarters as $q)
            <option value="{{ $q->id }}">{{ $q->section }}</option>
            @endforeach
          </select>
          <small class="text-danger" id="error-kuartal_id"></small>
          <div><small class="text-muted">Jika kosong maka akan mengikuti kuartal yang sedang aktif.</small></div>
        </div>
      </div>
      @endcan
      <div class="form-group row">
        <label for="kelompok_tani_id" class="col-md-3 col-form-label">Kelompok Tani <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <select name="kelompok_tani_id" id="kelompok_tani_id" class="form-control select2bs4 form-control-sm" style="width: 50%">
            <option value="">--- Pilih kelompok tani ---</option>
            @foreach ($kelompokTani as $k)
            <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
          </select>
          <small class="text-danger" id="error-kelompok_tani_id"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="blok" class="col-md-3 col-form-label">Nama Blok <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <select name="blok" id="blok" class="form-control select2bs4 form-control-sm" style="width: 50%">
            <option value="">--- Pilih blok ---</option>
            <option value="tunggul jati">Tunggul Jati</option>
            <option value="kudu keras">Kudu Keras</option>
            <option value="cigembor">Cigembor</option>
            <option value="cikupuk">Cikupuk</option>
            <option value="cekong">Cekong</option>
            <option value="pakuwon">Pakuwon</option>
            <option value="dukuh sajong">Dukuh Sajong</option>
            <option value="munjul">Munjul</option>
            <option value="getrak">Getrak</option>
            <option value="cipiit">Cipiit</option>
            <option value="cigelap">Cigelap</option>
            <option value="jambu boll">Jambu Boll</option>
            <option value="pedem kanyere">Pedem Kanyere</option>
            <option value="pamagang">Pamagang</option>
          </select>
          <small class="text-danger" id="error-blok"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="pemilik" class="col-md-3 col-form-label">Nama Pemilik <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="pemilik" class="form-control form-control-sm w-50" id="pemilik">
          <small class="text-danger" id="error-pemilik"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="luas_sawah" class="col-md-3 col-form-label">Luas Lahan Sawah <small class="text-muted">(ha)</small> <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="luas_sawah" class="form-control form-control-sm w-25" id="luas_sawah">
          <small class="text-danger" id="error-luas_sawah"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="luas_rencana" class="col-md-3 col-form-label">Luas Lahan Rencana <small class="text-muted">(ha)</small> <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="luas_rencana" class="form-control form-control-sm w-25" id="luas_rencana">
          <small class="text-danger" id="error-luas_rencana"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="alamat" class="col-md-3 col-form-label">Alamat Pemilik <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="alamat" class="form-control form-control-sm w-50" id="alamat">
          <small class="text-danger" id="error-alamat"></small>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <span class="text-muted"><strong class="text-danger">*</strong> Data wajib diisi.</span>
      <div class="float-right">
        <button type="submit" class="btn btn-success">Simpan</button>&nbsp; 
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
      </div>
    </div>
  </form>
</div>
<div class="card">
  <div class="card-header">
    <h5 class="card-title">Daftar Kepemilikan Lahan Pertanian</h5>
    <div class="card-tools">
      @can('kepemilikan_lahan_create')
      <button type="button" class="btn btn-tool" id="btn-open-card-add">
        <i class="fas fa-plus"></i>&nbsp; Tambah Kepemilikan Lahan
      </button>
      @endcan
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-hover text-sm" id="table">
      <thead>
        <tr class="text-center">
          <th rowspan="2" width="20px">No</th>
          <th rowspan="2" width="80px">Aksi</th>
          <th rowspan="2">Tahun</th>
          <th rowspan="2">Kuartal</th>
          <th rowspan="2">Blok</th>
          <th rowspan="2">Nama Pemilik</th>
          <th colspan="2">Luas Lahan <small class="text-muted">(ha)</small></th>
          <th rowspan="2">Alamat Pemilik</th>
          <th rowspan="2">Kelompok Tani</th>
          <th rowspan="2">Ditambahkan oleh</th>
        </tr>
        <tr class="text-center">
          <th>Sawah</th>
          <th>Rencana</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@section('js')
<script>
  $(function () {
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
  });

  let table = $('#table').DataTable({
    scrollX: true,
    processing: true,
    serverSide: true,
    ajax: '{{ route('kepemilikan-lahan.index') }}',
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
      {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false},
      {data: 'tahun', name: 'tahun', class: 'text-center'},
      {data: 'kuartal', name: 'kuartal', class: 'text-center'},
      {data: 'blok', name: 'blok'},
      {data: 'pemilik', name: 'pemilik'},
      {data: 'luas_sawah', name: 'luas_sawah', class: 'text-center'},
      {data: 'luas_rencana', name: 'luas_rencana', class: 'text-center'},
      {data: 'alamat', name: 'alamat'},
      {data: 'kelompok_tani_id', name: 'kelompok_tani_id'},
      {data: 'user_id', name: 'user_id'}
    ]
  });

  let cardTitleFormSubmit = document.getElementById('card-title');

  // Event untuk menampilkan form tambah banner
  let cardFormSubmit = document.getElementById('card-submit');
  document.getElementById('btn-open-card-add').addEventListener('click', function(event) {
    cardTitleFormSubmit.innerHTML = 'Tambah Kepemilikan Lahan Pertanian';
    clearAllInput();
    document.getElementById('_method').value = 'post';
      
    cardFormSubmit.style.display = 'block';
  });

  function onClickEdit(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    cardTitleFormSubmit.innerHTML = 'Edit Kepemilikan Lahan Pertanian';
    clearAllInput();
    document.getElementById('id').value = id;
    document.getElementById('_method').value = 'put';

    fetch(`{{ route('kepemilikan-lahan.index') }}/${id}/edit`)
      .then(res => res.json())
      .then(data => {
        if (data.status) {
          let _data = data.data;
          if ($('#kelompok_tani_id').length) {
            $('#kelompok_tani_id').val(_data.kelompok_tani_id).trigger('change');
          }
          if ($('#blok').length) {
            $('#blok').val(_data.blok).trigger('change');
          }
          if ($('#kuartal_id').length) {
            $('#kuartal_id').val(_data.kuartal_id).trigger('change');
          }
          if (document.getElementById('tahun')) {
            document.getElementById('tahun').value = _data.tahun ?? '';
          }
          document.getElementById('pemilik').value = _data.pemilik ?? '';
          document.getElementById('luas_sawah').value = _data.luas_sawah ?? '';
          document.getElementById('luas_rencana').value = _data.luas_rencana ?? '';
          document.getElementById('alamat').value = _data.alamat ?? '';
        }
    });

    cardFormSubmit.style.display = 'block';
  }

  function onClickDelete(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    Swal.fire({
      title: 'Hapus Data?',
      text: 'Apakah anda yakin data akan dihapus?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        fetch(`{{ route('kepemilikan-lahan.index') }}/${id}`, {
          headers: headersJSON,
          method: 'post',
          body: JSON.stringify({
            _method: 'delete'
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status) {
            $('.select2bs4').val('').trigger('change');
            Swal.fire({
              title: 'Sukses!',
              text: 'Selamat, data telah berhasil dihapus.',
              icon: 'success',
              onClose: () => table.ajax.reload()
            });
          } else {
            Swal.fire(
              'Gagal!',
              'Data tidak berhasil dihapus.',
              'error',
            );
          }
        })
        .catch(err => console.log(err));
      },
      allowOutsideClick: () => !Swal.isLoading() 
    });
  }

  function handleOnSubmit(event) {
    event.preventDefault();

    removeClassNameByClass('form-control', 'is-invalid');
    removeInnerHTMLByIds([
      'kelompok_tani_id',
      'tahun',
      'blok',
      'pemilik',
      'luas_sawah',
      'luas_rencana',
      'alamat'
    ], true);

    let id = document.getElementById('id').value ?? '';
    let method = document.getElementById('_method').value;
    let url = method == 'put' 
      ? `{{ route('kepemilikan-lahan.store') }}/${id}`
      : '{{ route('kepemilikan-lahan.store') }}'

    Swal.fire({
      title: 'Simpan Data?',
      text: 'Apakah anda yakin data akan disimpan?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, Simpan',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        fetch(url, {
          headers: headers,
          method: 'post',
          body: new FormData(event.target),
        })
        .then(res => {
          if (res.status !== 200) {
            Swal.fire(
              'Simpan Data Gagal!',
              'Pastikan data yang anda isi benar dan valid.',
              'error'
            );
          }
          return res.json();
        })
        .then(data => {
          if (data.errors !== undefined) {
            for (const [key, value] of Object.entries(data.errors)) {
              document.getElementById(`error-${key}`).innerHTML = value;
              document.getElementById(key).classList.add('is-invalid');
            }
          }

          if (data.status) {
            form.reset();
            cardFormSubmit.style.display = 'none';
            $('.select2bs4').val('').trigger('change');
            if (document.getElementById('preview-image')) {
              document.getElementById('preview-image').style.display = 'none';
            }
            Swal.fire({
              title: 'Sukses!',
              text: 'Selamat, data telah berhasil disimpan.',
              icon: 'success',
              onClose: () => table.ajax.reload()
            });
          } else {
            Swal.fire({
              title: 'Gagal!',
              text: data.msg ?? 'Terdapat kesalahan saat menyimpan.',
              icon: 'error'
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
