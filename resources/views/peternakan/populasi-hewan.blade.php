@extends('layouts.dashboard')
@section('title', 'Populasi Hewan :: '. config('app.name'))
@section('heading', 'Populasi Hewan')

@section('css')
<style>
  th, td {white-space: nowrap;}
</style>
@endsection

@section('content')
<div class="card card-outline card-primary" id="card-submit" style="display: none">
  <div class="card-header">
    <h5 class="card-title" id="card-title">Tambah Populasi Hewan</h5>
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
        <label for="hewan_id" class="col-md-3 col-form-label">Jenis Ternak <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <select name="hewan_id" id="hewan_id" class="form-control form-control-sm w-50">
            @foreach ($hewan as $h)
            <option value="{{ $h->id }}">{{ ucwords($h->nama) }}</option>
            @endforeach
          </select>
          <small class="text-danger" id="error-hewan_id"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="tahun" class="col-md-3 col-form-label">Tahun <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <select name="tahun" id="tahun" class="form-control form-control-sm w-25">
            <option value="2020">2020</option>
          </select>
          <small class="text-danger" id="error-tahun"></small>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 col-form-label">Populasi Awal <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Jantan</span>
                </div>
                <input type="text" name="populasi_awal_jantan" class="form-control form-control-sm" id="populasi_awal_jantan">
              </div>
              <small class="text-danger" id="error-populasi_awal_jantan"></small>
            </div>
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Betina</span>
                </div>
                <input type="text" name="populasi_awal_betina" class="form-control form-control-sm" id="populasi_awal_betina">
              </div>
              <small class="text-danger" id="error-populasi_awal_betina"></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 col-form-label">Jumlah lahir <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Jantan</span>
                </div>
                <input type="text" name="jumlah_lahir_jantan" class="form-control form-control-sm" id="jumlah_lahir_jantan">
              </div>
              <small class="text-danger" id="error-jumlah_lahir_jantan"></small>
            </div>
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Betina</span>
                </div>
                <input type="text" name="jumlah_lahir_betina" class="form-control form-control-sm" id="jumlah_lahir_betina">
              </div>
              <small class="text-danger" id="error-jumlah_lahir_betina"></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 col-form-label">Jumlah dipotong <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Jantan</span>
                </div>
                <input type="text" name="jumlah_dipotong_jantan" class="form-control form-control-sm" id="jumlah_dipotong_jantan">
              </div>
              <small class="text-danger" id="error-jumlah_dipotong_jantan"></small>
            </div>
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Betina</span>
                </div>
                <input type="text" name="jumlah_dipotong_betina" class="form-control form-control-sm" id="jumlah_dipotong_betina">
              </div>
              <small class="text-danger" id="error-jumlah_dipotong_betina"></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="hewan_id" class="col-md-3 col-form-label">Jumlah mati <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Jantan</span>
                </div>
                <input type="text" name="jumlah_mati_jantan" class="form-control form-control-sm" id="jumlah_mati_jantan">
              </div>
              <small class="text-danger" id="error-jumlah_mati_jantan"></small>
            </div>
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Betina</span>
                </div>
                <input type="text" name="jumlah_mati_betina" class="form-control form-control-sm" id="jumlah_mati_betina">
              </div>
              <small class="text-danger" id="error-jumlah_mati_betina"></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="hewan_id" class="col-md-3 col-form-label">Jumlah masuk <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Jantan</span>
                </div>
                <input type="text" name="jumlah_masuk_jantan" class="form-control form-control-sm" id="jumlah_masuk_jantan">
              </div>
              <small class="text-danger" id="error-jumlah_masuk_jantan"></small>
            </div>
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Betina</span>
                </div>
                <input type="text" name="jumlah_masuk_betina" class="form-control form-control-sm" id="jumlah_masuk_betina">
              </div>
              <small class="text-danger" id="error-jumlah_masuk_betina"></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="hewan_id" class="col-md-3 col-form-label">Jumlah keluar <span class="text-danger">*</span></label>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Jantan</span>
                </div>
                <input type="text" name="jumlah_keluar_jantan" class="form-control form-control-sm" id="jumlah_keluar_jantan">
              </div>
              <small class="text-danger" id="error-jumlah_keluar_jantan"></small>
            </div>
            <div class="col-md-4">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text">Betina</span>
                </div>
                <input type="text" name="jumlah_keluar_betina" class="form-control form-control-sm" id="jumlah_keluar_betina">
              </div>
              <small class="text-danger" id="error-jumlah_keluar_betina"></small>
            </div>
          </div>
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
    <h5 class="card-title">Daftar populasi hewan</h5>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" id="btn-open-card-add">
        <i class="fas fa-plus"></i>&nbsp; Tambah Populasi Hewan
      </button>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-hover" id="table">
      <thead>
        <tr class="text-center">
          <th rowspan="2">No</th>
          <th rowspan="2">Aksi</th>
          <th rowspan="2">Jenis Ternak</th>
          <th colspan="2">Populasi Awal</th>
          <th colspan="2">Lahir</th>
          <th colspan="2">Dipotong</th>
          <th colspan="2">Mati</th>
          <th colspan="2">Masuk</th>
          <th colspan="2">Keluar</th>
          <th colspan="2">Populasi Akhir</th>
          <th rowspan="2">Ditambahkan oleh</th>
        </tr>
        <tr class="text-center">
          <th>Jan</th>
          <th>Bet</th>
          <th>Jan</th>
          <th>Bet</th>
          <th>Jan</th>
          <th>Bet</th>
          <th>Jan</th>
          <th>Bet</th>
          <th>Jan</th>
          <th>Bet</th>
          <th>Jan</th>
          <th>Bet</th>
          <th>Jan</th>
          <th>Bet</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@section('js')
<script>
  let table = $('#table').DataTable({
    scrollX: true,
    processing: true,
    serverSide: true,
    ajax: '{{ route('populasi-hewan.index') }}',
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center'},
      {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false},
      {data: 'hewan_id', name: 'hewan_id'},
      {data: 'awal_jan', name: 'awal_jan', class: 'text-center'},
      {data: 'awal_bet', name: 'awal_bet', class: 'text-center'},
      {data: 'lahir_jan', name: 'lahir_jan', class: 'text-center'},
      {data: 'lahir_bet', name: 'lahir_bet', class: 'text-center'},
      {data: 'dipotong_jan', name: 'dipotong_jan', class: 'text-center'},
      {data: 'dipotong_bet', name: 'dipotong_bet', class: 'text-center'},
      {data: 'mati_jan', name: 'mati_jan', class: 'text-center'},
      {data: 'mati_bet', name: 'mati_bet', class: 'text-center'},
      {data: 'masuk_jan', name: 'masuk_jan', class: 'text-center'},
      {data: 'masuk_bet', name: 'masuk_bet', class: 'text-center'},
      {data: 'keluar_jan', name: 'keluar_jan', class: 'text-center'},
      {data: 'keluar_bet', name: 'keluar_bet', class: 'text-center'},
      {data: 'akhir_jan', name: 'akhir_jan', class: 'text-center'},
      {data: 'akhir_bet', name: 'akhir_bet', class: 'text-center'},
      {data: 'user_id', name: 'user_id'}
    ]
  });

  let cardTitleFormSubmit = document.getElementById('card-title');

  // Event untuk menampilkan form tambah banner
  let cardFormSubmit = document.getElementById('card-submit');
  document.getElementById('btn-open-card-add').addEventListener('click', function(event) {
    cardTitleFormSubmit.innerHTML = 'Tambah Populasi Hewan';
    clearAllInput();
    document.getElementById('_method').value = 'post';
      
    cardFormSubmit.style.display = 'block';
  });

  function onClickEdit(event) {
    event.preventDefault();

    let id = event.target.getAttribute('data-id');

    cardTitleFormSubmit.innerHTML = 'Edit Populasi Hewan';
    clearAllInput();
    document.getElementById('id').value = id;
    document.getElementById('_method').value = 'put';

    fetch(`{{ route('populasi-hewan.index') }}/${id}/edit`)
      .then(res => res.json())
      .then(data => {
        if (data.status) {
          let hewan = data.hewan;
          document.getElementById('nama').value = hewan.nama ?? '';
        }
    });

    cardFormSubmit.style.display = 'block';
  }

  function handleOnSubmit(event) {
    event.preventDefault();

    removeClassNameByClass('form-control', 'is-invalid');
    removeInnerHTMLByIds([
      'hewan_id',
      'tahun',
      'populasi_awal_jantan',
      'populasi_awal_betina',
      'jumlah_lahir_jantan',
      'jumlah_lahir_betina',
      'jumlah_dipotong_jantan',
      'jumlah_dipotong_betina',
      'jumlah_mati_jantan',
      'jumlah_mati_betina',
      'jumlah_masuk_jantan',
      'jumlah_masuk_betina',
      'jumlah_keluar_jantan',
      'jumlah_keluar_betina',
    ], true);

    let id = document.getElementById('id').value ?? '';
    let method = document.getElementById('_method').value;
    let url = method == 'put' 
      ? `{{ route('populasi-hewan.store') }}/${id}`
      : '{{ route('populasi-hewan.store') }}'

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
