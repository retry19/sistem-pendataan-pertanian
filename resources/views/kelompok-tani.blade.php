@extends('layouts.dashboard')
@section('title', 'Daftar Kelompok Tani :: '. config('app.name'))
@section('heading', 'Daftar Kelompok Tani')

@section('content')
<div class="row">
  <div class="col-md-7">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Kelompok Tani</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" id="btn-open-card-add">
            <i class="fas fa-plus"></i>&nbsp; Tambah Kelompok Tani
          </button>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover" id="table">
          <thead>
            <tr class="text-center">
              <th width="30px">No</th>
              <th>Nama</th>
              <th width="100px">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="card card-outline card-primary" id="card-submit" style="display: none">
      <div class="card-header">
        <h5 class="card-title" id="card-title">Tambah Kelompok Tani</h5>
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
            <label for="nama" class="col-sm-4 col-form-label">Nama <span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="nama" id="nama">
              <small class="text-danger" id="error-nama"></small>
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
  </div>
</div>
@endsection

@section('js')
<script>
  let table = $('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('kelompok-tani.index') }}',
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
      {data: 'nama', name: 'nama'},
      {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false}
    ]
  });

  let cardTitleFormSubmit = document.getElementById('card-title');

  // Event untuk menampilkan form tambah banner
  let cardFormSubmit = document.getElementById('card-submit');
  document.getElementById('btn-open-card-add').addEventListener('click', function(event) {
    cardTitleFormSubmit.innerHTML = 'Tambah Kelompok Tani';
    clearAllInput();
    document.getElementById('_method').value = 'post';
      
    cardFormSubmit.style.display = 'block';
  });

  function onClickEdit(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    cardTitleFormSubmit.innerHTML = 'Edit Kelompok Tani';
    clearAllInput();
    document.getElementById('id').value = id;
    document.getElementById('_method').value = 'put';

    fetch(`{{ route('kelompok-tani.index') }}/${id}/edit`)
      .then(res => res.json())
      .then(data => {
        if (data.status) {
          let _data = data.data;
          document.getElementById('nama').value = _data.nama ?? '';
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
        fetch(`{{ route('kelompok-tani.index') }}/${id}`, {
          headers: headersJSON,
          method: 'post',
          body: JSON.stringify({
            _method: 'delete'
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status) {
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
      'nama',
    ], true);

    let id = document.getElementById('id').value ?? '';
    let method = document.getElementById('_method').value;
    let url = method == 'put' 
      ? `{{ route('kelompok-tani.store') }}/${id}`
      : '{{ route('kelompok-tani.store') }}'

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
            if (document.getElementById('preview-image')) {
              document.getElementById('preview-image').style.display = 'none';
            }
            Swal.fire({
              title: 'Sukses!',
              text: 'Selamat, data telah berhasil disimpan.',
              icon: 'success',
              onClose: () => table.ajax.reload()
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
