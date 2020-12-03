@extends('layouts.dashboard')

@section('title', 'Edit Profil :: '. config('app.name'))
@section('heading', 'Edit Profil')

@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h5 class="card-title">Profil</h5>
  </div>
  <form id="form">
    @method('put')
    <div class="card-body">
      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
        <div class="col-sm-10">
          <input type="text" class="form-control w-50" name="name" id="name" placeholder="Masukan nama lengkap" value="{{ $user->name }}">
          <small class="text-danger" id="error-name"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="birth_date" class="col-sm-2 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
        <div class="col-sm-10">
          <input type="date" class="form-control w-25" name="birth_date" id="birth_date" placeholder="Pilih tanggal lahir" value="{{ \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') }}">
          <small class="text-danger" id="error-birth_date"></small>
        </div>
      </div>
      <div class="form-group row pt-2 pb-3">
        <label for="username" class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
        <div class="col-sm-10">
          <input type="text" class="form-control w-50" name="username" id="username" placeholder="Masukan username" value="{{ $user->username }}">
          <small class="text-danger" id="error-username"></small>
        </div>
      </div>
      <hr>
      <h5>Ubah Password</h5>
      <div class="form-group row">
        <label for="password_old" class="col-sm-2 col-form-label">Password lama</label>
        <div class="col-sm-10">
          <input type="password" class="form-control w-50" name="password_old" id="password_old" placeholder="Masukan password lama">
          <small class="text-danger" id="error-password_old"></small>
        </div>
      </div>
      <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">Password Baru</label>
        <div class="col-sm-10">
          <input type="password" class="form-control w-50" name="password" id="password" placeholder="Masukan password baru">
          <small class="text-danger" id="error-password"></small>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <span class="text-muted"><strong class="text-danger">*</strong> Data wajib diisi.</span>
      <div class="float-right">
        <button type="submit" class="btn btn-success">Perbaharui</button> 
      </div>
    </div>
  </form>    
</div>
@endsection

@section('js')
<script>
  function handleOnSubmit(event) {
    event.preventDefault();

    removeClassNameByClass('form-control', 'is-invalid');
    removeInnerHTMLByIds([
      'name',
      'birth_date',
      'username',
      'password_old',
      'password',
    ], true);

    let method = 'post';
    let url = '{{ route('users.update-profile') }}';

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
          if (data.errors !== undefined) {
            for (const [key, value] of Object.entries(data.errors)) {
              document.getElementById(`error-${key}`).innerHTML = value;
              document.getElementById(key).classList.add('is-invalid');
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
