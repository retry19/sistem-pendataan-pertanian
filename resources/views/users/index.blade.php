@extends('layouts.dashboard')
@section('title', 'Kelola Akun :: '. config('app.name'))
@section('heading', 'Kelola Akun')

@section('content')
<div class="card card-outline card-primary" id="card-submit" style="display: none">
  <div class="card-header">
    <h5 class="card-title" id="card-title">Tambah Akun</h5>
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
        <label for="name" class="col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="name" class="form-control" id="name">
          <small class="text-danger" id="error-name"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="birth_date" class="col-md-3 col-form-label">Tanggal lahir <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="date" name="birth_date" class="form-control w-50" id="birth_date">
          <small class="text-danger" id="error-birth_date"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="username" class="col-md-3 col-form-label">Username <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <input type="text" name="username" class="form-control" id="username">
          <small class="text-danger" id="error-username"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="roles" class="col-md-3 col-form-label">Roles <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <select name="roles[]" class="form-control select2" multiple="multiple" id="roles" data-placeholder="Pilih permission">
            @foreach ($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
          </select>
          <small class="text-danger" id="error-roles"></small>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <span class="text-muted"><strong class="text-danger">*</strong> Data wajib diisi.</span><br>
      <span class="text-muted">Password akan diambil dari tanggal lahir (format: hari bulan tahun), contoh : <mark>23122020</mark>.</span>
      <div class="float-right">
        <button type="submit" class="btn btn-success">Simpan</button>&nbsp; 
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
      </div>
    </div>
  </form>
</div>
<div class="card">
  <div class="card-header">
    <h5 class="card-title">Daftar Akun</h5>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" id="btn-open-card-add">
        <i class="fas fa-plus"></i>&nbsp; Tambah Akun
      </button>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-hover" id="table">
      <thead>
        <tr class="text-center">
          <th width="30px">No</th>
          <th width="200px">Nama</th>
          <th width="150px">Tanggal Lahir</th>
          <th width="200px">Username</th>
          <th>Role</th>
          <th width="100px">Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@section('js')
<script>
  $(function () {
    $('.select2').select2({
      theme: 'bootstrap4',
      width: '100%',
      dropdownParent: $('#card-submit')
    });
  });

  let table = $('#table').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: '{{ route('users.index') }}',
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
      {data: 'name', name: 'name'},
      {data: 'birth_date', name: 'birth_date', class: 'text-center'},
      {data: 'username', name: 'username', class: 'text-center'},
      {data: 'roles', name: 'roles', class: 'text-center'},
      {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false},
    ]
  });

  let cardTitleFormSubmit = document.getElementById('card-title');

  // Event untuk menampilkan form tambah banner
  let cardFormSubmit = document.getElementById('card-submit');
  document.getElementById('btn-open-card-add').addEventListener('click', function(event) {
    cardTitleFormSubmit.innerHTML = 'Tambah Akun';
    clearAllInput();
    document.getElementById('_method').value = 'post';
      
    cardFormSubmit.style.display = 'block';
  });

  function onClickEdit(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    cardTitleFormSubmit.innerHTML = 'Edit Akun';
    clearAllInput();
    document.getElementById('id').value = id;
    document.getElementById('_method').value = 'put';

    fetch(`{{ route('users.index') }}/${id}/edit`)
      .then(res => res.json())
      .then(data => {
        if (data.status) {
          let _data = data.data;
          document.getElementById('name').value = _data.name ?? '';
          document.getElementById('birth_date').value = data.birth_date ?? '';
          document.getElementById('username').value = _data.username ?? '';
          $('.select2').val(data.roles).trigger('change');
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
        fetch(`{{ route('users.index') }}/${id}`, {
          headers: headersJSON,
          method: 'post',
          body: JSON.stringify({
            _method: 'delete'
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status) {
            $('.select2').val('').trigger('change');
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
      'name',
      'birth_date',
      'username',
      'roles'
    ], true);

    let id = document.getElementById('id').value ?? '';
    let method = document.getElementById('_method').value;
    let url = method == 'put' 
      ? `{{ route('users.store') }}/${id}`
      : '{{ route('users.store') }}'

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
            $('.select2').val('').trigger('change'); // <--- hati-hati harus di hapus apabila tidak pakai
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
