@extends('layouts.dashboard')
@section('title', 'Organisme Pengganggu :: '. config('app.name'))
@section('heading', 'Organisme Pengganggu')

@section('css')
<style>
  th, td { white-space: nowrap; }
</style>
@endsection

@section('content')
<div class="card card-outline card-primary" id="card-submit" style="display: none">
  <div class="card-header">
    <h5 class="card-title" id="card-title">Tambah Organisme Pengganggu</h5>
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
        <label for="tanaman_id" class="col-md-3 col-form-label">Jenis Tanaman <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <select name="tanaman_id" id="tanaman_id" class="form-control select2bs4 form-control-sm" style="width: 25%">
            <option value="">--- Pilih tanaman ---</option>
            @foreach ($tanaman as $t)
            <option value="{{ $t->id }}">{{ ucwords($t->nama) }}</option>
            @endforeach
          </select>
          <small class="text-danger" id="error-tanaman_id"></small>
        </div>
      </div>
      @can('organisme_pengganggu_quarter')
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
        <label for="bencana" class="col-md-3 col-form-label">Jenis OTP / Bencana <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="bencana" class="form-control form-control-sm w-25" id="bencana">
          <small class="text-danger" id="error-bencana"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="luas_serangan" class="col-md-3 col-form-label">Luas Serangan <small class="text-muted">(ha)</small> <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="luas_serangan" class="form-control form-control-sm w-25" id="luas_serangan">
          <small class="text-danger" id="error-luas_serangan"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="upaya" class="col-md-3 col-form-label">Upaya yang telah dilakukan <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="upaya" class="form-control form-control-sm w-25" id="upaya">
          <small class="text-danger" id="error-upaya"></small>
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
    <h5 class="card-title">Daftar Organisme Pengganggu</h5>
    <div class="card-tools">
      @can('organisme_pengganggu_create')
      <button type="button" class="btn btn-tool" id="btn-open-card-add">
        <i class="fas fa-plus"></i>&nbsp; Tambah Organisme Pengganggu
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
          <th>Jenis OTP / Bencana</th>
          <th>Luas Serangan <small class="text-muted">(ha)</small></th>
          <th>Upaya yang telah dilakukan</th>
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
    ajax: '{{ route('organisme-pengganggu.index') }}',
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
      {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false},
      {data: 'tanaman_id', name: 'tanaman_id'},
      {data: 'tahun', name: 'tahun', class: 'text-center'},
      {data: 'kuartal', name: 'kuartal', class: 'text-center'},
      {data: 'bencana', name: 'bencana'},
      {data: 'luas_serangan', name: 'luas_serangan', class: 'text-center'},
      {data: 'upaya', name: 'upaya'},
      {data: 'user_id', name: 'user_id'}
    ]
  });

  let cardTitleFormSubmit = document.getElementById('card-title');

  // Event untuk menampilkan form tambah banner
  let cardFormSubmit = document.getElementById('card-submit');
  document.getElementById('btn-open-card-add').addEventListener('click', function(event) {
    cardTitleFormSubmit.innerHTML = 'Tambah Organisme Pengganggu';
    clearAllInput();
    document.getElementById('_method').value = 'post';
      
    cardFormSubmit.style.display = 'block';
  });

  function onClickEdit(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    cardTitleFormSubmit.innerHTML = 'Edit Organisme Pengganggu';
    clearAllInput();
    document.getElementById('id').value = id;
    document.getElementById('_method').value = 'put';

    fetch(`{{ route('organisme-pengganggu.index') }}/${id}/edit`)
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
          document.getElementById('bencana').value = _data.bencana ?? '';
          document.getElementById('luas_serangan').value = _data.luas_serangan ?? '';
          document.getElementById('upaya').value = _data.upaya ?? '';
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
        fetch(`{{ route('organisme-pengganggu.index') }}/${id}`, {
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
      'bencana',
      'luas_serangan',
      'upaya'
    ], true);

    let id = document.getElementById('id').value ?? '';
    let method = document.getElementById('_method').value;
    let url = method == 'put' 
      ? `{{ route('organisme-pengganggu.store') }}/${id}`
      : '{{ route('organisme-pengganggu.store') }}'

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
