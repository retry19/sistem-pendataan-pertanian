@extends('layouts.dashboard')
@section('title', 'Luas Tanam :: '. config('app.name'))
@section('heading', 'Luas Tanam')

@section('css')
<style>
  th, td { white-space: nowrap; }
</style>
@endsection

@section('content')
<div class="card card-outline card-primary" id="card-submit" style="display: none">
  <div class="card-header">
    <h5 class="card-title" id="card-title">Tambah Luas Tanam</h5>
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
      <div class="form-group row">
        <label for="tanaman_id" class="col-md-2 col-form-label">Jenis Tanaman <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <select name="tanaman_id" id="tanaman_id" class="form-control select2bs4 form-control-sm" style="width: 25%">
            <option value="">--- Pilih tanaman ---</option>
            @foreach ($tanaman as $t)
            <option value="{{ $t->id }}">{{ ucwords($t->nama) }}</option>
            @endforeach
          </select>
          <small class="text-danger" id="error-tanaman_id"></small>
        </div>
      </div>
      @can('luas_tanam_quarter')
      <div class="form-group row">
        <label for="tahun" class="col-md-2 col-form-label">Tahun</label>
        <div class="col-md-10">
          <input type="text" name="tahun" class="form-control form-control-sm w-25" id="tahun">
          <small class="text-danger" id="error-tahun"></small>
          <div><small class="text-muted">Jika kosong maka akan mengikuti tahun saat ini.</small></div>
        </div>
      </div>
      <div class="form-group row">
        <label for="kuartal_id" class="col-md-2 col-form-label">Kuartal</label>
        <div class="col-md-10">
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
        <label for="tanaman_awal" class="col-md-2 col-form-label">Tanaman Bulan Lalu <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <input type="text" name="tanaman_awal" class="form-control form-control-sm w-25" id="tanaman_awal">
          <small class="text-danger" id="error-tanaman_awal"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="sdg_menghasilkan" class="col-md-2 col-form-label">Panen</label>
        <div class="col-md-10">
          <input type="text" name="sdg_menghasilkan" class="form-control form-control-sm w-25" id="sdg_menghasilkan">
          <small class="text-danger" id="error-sdg_menghasilkan"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="luas_rusak" class="col-md-2 col-form-label">Puso</label>
        <div class="col-md-10">
          <input type="text" name="luas_rusak" class="form-control form-control-sm w-25" id="luas_rusak">
          <small class="text-danger" id="error-luas_rusak"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="ditambah" class="col-md-2 col-form-label">Tambah Tanam</label>
        <div class="col-md-10">
          <input type="text" name="ditambah" class="form-control form-control-sm w-25" id="ditambah">
          <small class="text-danger" id="error-ditambah"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="produktifitas" class="col-md-2 col-form-label">Produktifitas</label>
        <div class="col-md-10">
          <input type="text" name="produktifitas" class="form-control form-control-sm w-25" id="produktifitas">
          <small class="text-danger" id="error-produktifitas"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="produksi" class="col-md-2 col-form-label">Produksi</label>
        <div class="col-md-10">
          <input type="text" name="produksi" class="form-control form-control-sm w-25" id="produksi">
          <small class="text-danger" id="error-produksi"></small>
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
    <h5 class="card-title">Daftar Luas Tanam</h5>
    <div class="card-tools">
      @can('luas_tanam_create')
      <button type="button" class="btn btn-tool" id="btn-open-card-add">
        <i class="fas fa-plus"></i>&nbsp; Tambah Luas Tanam
      </button>
      @endcan
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-hover text-sm" id="table">
      <thead>
        <tr class="text-center">
          <th width="20px">No</th>
          <th width="80px">Aksi</th>
          <th>Jenis Tanaman</th>
          <th>Tahun</th>
          <th>Kuartal</th>
          <th>Tanaman Bulan Lalu</th>
          <th>Panen</th>
          <th>Puso</th>
          <th>Tambah Tanam</th>
          <th>Tanaman Akhir Bulan</th>
          <th>Produktifitas</th>
          <th>Produksi</th>
          <th>Ditambahkan oleh</th>
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
    ajax: '{{ route('luas-tanam.index') }}',
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
      {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false},
      {data: 'tanaman_id', name: 'tanaman_id'},
      {data: 'tahun', name: 'tahun', class: 'text-center'},
      {data: 'kuartal', name: 'kuartal', class: 'text-center'},
      {data: 'tanaman_awal', name: 'tanaman_awal', class: 'text-center'},
      {data: 'sdg_menghasilkan', name: 'sdg_menghasilkan', class: 'text-center'},
      {data: 'luas_rusak', name: 'luas_rusak', class: 'text-center'},
      {data: 'ditambah', name: 'ditambah', class: 'text-center'},
      {data: 'tanaman_akhir', name: 'tanaman_akhir', class: 'text-center'},
      {data: 'produktifitas', name: 'produktifitas', class: 'text-center'},
      {data: 'produksi', name: 'produksi', class: 'text-center'},
      {data: 'user_id', name: 'user_id'}
    ]
  });

  let cardTitleFormSubmit = document.getElementById('card-title');

  // Event untuk menampilkan form tambah banner
  let cardFormSubmit = document.getElementById('card-submit');
  document.getElementById('btn-open-card-add').addEventListener('click', function(event) {
    cardTitleFormSubmit.innerHTML = 'Tambah Luas Tanam';
    clearAllInput();
    document.getElementById('_method').value = 'post';
      
    cardFormSubmit.style.display = 'block';
  });

  function onClickEdit(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    cardTitleFormSubmit.innerHTML = 'Edit Luas Tanam';
    clearAllInput();
    document.getElementById('id').value = id;
    document.getElementById('_method').value = 'put';

    fetch(`{{ route('luas-tanam.index') }}/${id}/edit`)
      .then(res => res.json())
      .then(data => {
        if (data.status) {
          let _data = data.data;
          if ($('#tanaman_id').length) {
            $('#tanaman_id').val(_data.tanaman_id).trigger('change');
          }
          if ($('#kuartal_id').length) {
            $('#kuartal_id').val(_data.kuartal_id).trigger('change');
          }
          if (document.getElementById('tahun')) {
            document.getElementById('tahun').value = _data.tahun ?? '';
          }
          document.getElementById('tanaman_awal').value = _data.tanaman_awal ?? '';
          document.getElementById('sdg_menghasilkan').value = _data.sdg_menghasilkan ?? '';
          document.getElementById('luas_rusak').value = _data.luas_rusak ?? '';
          document.getElementById('ditambah').value = _data.ditambah ?? '';
          document.getElementById('produktifitas').value = _data.produktifitas ?? '';
          document.getElementById('produksi').value = _data.produksi ?? '';
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
        fetch(`{{ route('luas-tanam.index') }}/${id}`, {
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
      'tanaman_id',
      'tahun',
      'tanaman_awal',
      'sdg_menghasilkan',
      'luas_rusak',
      'ditambah',
      'produktifitas',
      'produksi'
    ], true);

    let id = document.getElementById('id').value ?? '';
    let method = document.getElementById('_method').value;
    let url = method == 'put' 
      ? `{{ route('luas-tanam.store') }}/${id}`
      : '{{ route('luas-tanam.store') }}'

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

