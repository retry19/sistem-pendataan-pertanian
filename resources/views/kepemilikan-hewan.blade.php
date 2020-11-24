@extends('layouts.dashboard')
@section('title', 'Kepemilikan Hewan :: '. config('app.name'))
@section('heading', 'Kepemilikan Hewan')

@section('content')
<div class="card card-outline card-primary" id="card-submit" style="display: none">
  <div class="card-header">
    <h5 class="card-title" id="card-title">Tambah Kepemilikan Hewan</h5>
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
        <label for="hewan_id" class="col-md-2 col-form-label">Hewan <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <select name="hewan_id" id="hewan_id" class="form-control select2bs4 form-control-sm" style="width: 50%">
            <option value="">--- Pilih hewan ---</option>
            @foreach ($hewan as $h)
            <option value="{{ $h->id }}">{{ ucwords($h->nama) }}</option>
            @endforeach
          </select>
          <small class="text-danger" id="error-hewan_id"></small>
        </div>
      </div>
      @can('kepemilikan_hewan_quarter')
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
        <label for="blok" class="col-md-2 col-form-label">Blok <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <input type="text" name="blok" class="form-control form-control-sm w-50" id="blok">
          <small class="text-danger" id="error-blok"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="pemilik" class="col-md-2 col-form-label">Pemilik <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <input type="text" name="pemilik" class="form-control form-control-sm w-50" id="pemilik">
          <small class="text-danger" id="error-pemilik"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="jumlah" class="col-md-2 col-form-label">Jumlah <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <input type="text" name="jumlah" class="form-control form-control-sm w-25" id="jumlah">
          <small class="text-danger" id="error-jumlah"></small>
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
    <h5 class="card-title">Daftar kepemilikan hewan</h5>
    <div class="card-tools">
      @can('kepemilikan_hewan_create')
      <button type="button" class="btn btn-tool" id="btn-open-card-add">
        <i class="fas fa-plus"></i>&nbsp; Tambah Kepemilikan Hewan
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
          <th>Hewan</th>
          <th width="50px">Tahun</th>
          <th width="50px">Kuartal</th>
          <th>Blok</th>
          <th>Pemilik</th>
          <th width="50px">Jumlah</th>
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
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: '{{ route('kepemilikan-hewan.index') }}',
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
      {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false},
      {data: 'hewan_id', name: 'hewan_id'},
      {data: 'tahun', name: 'tahun', class: 'text-center'},
      {data: 'kuartal', name: 'kuartal', class: 'text-center'},
      {data: 'blok', name: 'blok'},
      {data: 'pemilik', name: 'pemilik'},
      {data: 'jumlah', name: 'jumlah', class: 'text-center'},
      {data: 'user_id', name: 'user_id'}
    ]
  });

  let cardTitleFormSubmit = document.getElementById('card-title');

  // Event untuk menampilkan form tambah banner
  let cardFormSubmit = document.getElementById('card-submit');
  document.getElementById('btn-open-card-add').addEventListener('click', function(event) {
    cardTitleFormSubmit.innerHTML = 'Tambah Kepemilikan Hewan';
    clearAllInput();
    document.getElementById('_method').value = 'post';
      
    cardFormSubmit.style.display = 'block';
  });

  function onClickEdit(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    cardTitleFormSubmit.innerHTML = 'Edit Kepemilikan Hewan';
    clearAllInput();
    document.getElementById('id').value = id;
    document.getElementById('_method').value = 'put';

    fetch(`{{ route('kepemilikan-hewan.index') }}/${id}/edit`)
      .then(res => res.json())
      .then(data => {
        if (data.status) {
          let _data = data.data;
          if ($('#hewan_id').length) {
            $('#hewan_id').val(_data.hewan_id).trigger('change');
          }
          if ($('#kuartal_id').length) {
            $('#kuartal_id').val(_data.kuartal_id).trigger('change');
          }
          if (document.getElementById('tahun')) {
            document.getElementById('tahun').value = _data.tahun ?? '';
          }
          document.getElementById('blok').value = _data.blok ?? '';
          document.getElementById('pemilik').value = _data.pemilik ?? '';
          document.getElementById('jumlah').value = _data.jumlah ?? '';
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
        fetch(`{{ route('kepemilikan-hewan.index') }}/${id}`, {
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
      'hewan_id',
      'tahun',
      'blok',
      'pemilik',
      'jumlah',
    ], true);

    let id = document.getElementById('id').value ?? '';
    let method = document.getElementById('_method').value;
    let url = method == 'put' 
      ? `{{ route('kepemilikan-hewan.store') }}/${id}`
      : '{{ route('kepemilikan-hewan.store') }}'

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
