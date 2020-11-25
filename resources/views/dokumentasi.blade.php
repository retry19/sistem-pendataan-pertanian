@extends('layouts.dashboard')
@section('title', 'Dokumentasi :: '. config('app.name'))
@section('heading', 'Dokumentasi')

@section('content')
<div class="card card-outline card-primary" id="card-submit" style="display: none">
  <div class="card-header">
    <h5 class="card-title" id="card-title">Tambah Dokumentasi</h5>
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
        <label for="tanggal" class="col-md-2 col-form-label">Tanggal <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <input type="date" name="tanggal" class="form-control form-control-sm w-25" id="tanggal">
          <small class="text-danger" id="error-tanggal"></small>
        </div>
      </div>
      @can('dokumentasi_quarter')
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
        <label for="deskripsi" class="col-md-2 col-form-label">Deskripsi <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <textarea name="deskripsi" class="form-control form-control-sm w-50" id="deskripsi"></textarea>
          <small class="text-danger" id="error-deskripsi"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="gambar" class="col-md-2 col-form-label">Gambar <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <input type="file" name="gambar" id="gambar" accept="image/*">
          <small class="text-danger" id="error-gambar"></small>
        </div>
      </div>
      <div class="form-group row" id="preview-image" style="display: none">
        <label class="col-sm-2 col-form-label">Preview</label>
        <div class="col-sm-10">
          <img class="img-fluid img-thumbnail" src="" id="preview-image-output">
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
    <h5 class="card-title">Daftar Dokumentasi</h5>
    <div class="card-tools">
      @can('dokumentasi_create')
      <button type="button" class="btn btn-tool" id="btn-open-card-add">
        <i class="fas fa-plus"></i>&nbsp; Tambah Dokumentasi
      </button>
      @endcan
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-hover" id="table">
      <thead>
        <tr class="text-center">
          <th width="20px">No</th>
          <th width="80px">Aksi</th>
          <th>Tanggal</th>
          <th width="50px">Kuartal</th>
          <th>Gambar</th>
          <th>Deskripsi</th>
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

  // Memberi event ketika memilih gambar
  let uploadImage = document.getElementById('gambar');
  uploadImage.addEventListener('change', loadImage);

  let table = $('#table').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: '{{ route('dokumentasi.index') }}',
    aoColumnDefs: [{'bSortable': false, 'aTargets': [0]},{'bSearchable': false, 'aTargets': [0]}],
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
      {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false},
      {data: 'tanggal', name: 'tanggal', class: 'text-center'},
      {data: 'kuartal_id', name: 'kuartal_id', class: 'text-center'},
      {data: 'gambar', name: 'gambar', class: 'text-center'},
      {data: 'deskripsi', name: 'deskripsi'},
      {data: 'user_id', name: 'user_id'}
    ]
  });

  let cardTitleFormSubmit = document.getElementById('card-title');

  // Event untuk menampilkan form tambah banner
  let cardFormSubmit = document.getElementById('card-submit');
  document.getElementById('btn-open-card-add').addEventListener('click', function(event) {
    cardTitleFormSubmit.innerHTML = 'Tambah Dokumentasi';
    clearAllInput();
    document.getElementById('_method').value = 'post';
      
    cardFormSubmit.style.display = 'block';
  });

  function onClickEdit(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    cardTitleFormSubmit.innerHTML = 'Edit Dokumentasi';
    clearAllInput();
    document.getElementById('id').value = id;
    document.getElementById('_method').value = 'put';

    fetch(`{{ route('dokumentasi.index') }}/${id}/edit`)
      .then(res => res.json())
      .then(data => {
        if (data.status) {
          let _data = data.data;
          if ($('#kuartal_id').length) {
            $('#kuartal_id').val(_data.kuartal_id).trigger('change');
          }
          document.getElementById('deskripsi').value = _data.deskripsi ?? '';
          document.getElementById('tanggal').value = data.tanggal ?? '';
          document.getElementById('preview-image-output').src = _data.gambar ? `../storage/${_data.gambar}` : '';
          document.getElementById('preview-image').style.display = _data.gambar ? 'flex' : 'none';
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
        fetch(`{{ route('dokumentasi.index') }}/${id}`, {
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
      'tanggal',
      'tahun',
      'deskripsi',
    ], true);

    let id = document.getElementById('id').value ?? '';
    let method = document.getElementById('_method').value;
    let url = method == 'put' 
      ? `{{ route('dokumentasi.store') }}/${id}`
      : '{{ route('dokumentasi.store') }}'

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
