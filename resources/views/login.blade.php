<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login :: {{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
  <div class="login-logo" style="width: 450px">
    <a href="">{{ config('app.name') }}</a>
  </div>
  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Login untuk administrator</p>

        <form id="form">
          <div class="input-group">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username *">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <small class="text-danger" id="error-username"></small>
          <div class="input-group mt-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password *">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <small class="text-danger" id="error-password"></small>
          <div class="row mt-3">
            <div class="offset-8 col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

  <div class="wrapper-loading" id="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    function handleOnSubmit(event) {
      event.preventDefault();

      removeClassNameByClass('form-control', 'is-invalid');
      removeInnerHTMLByIds([
        'username',
        'password',
      ], true);

      let method = 'post';
      let url = '{{ route('auth.login') }}';

      Swal.fire({
        title: 'Login?',
        text: 'Pastikan semua data telah benar.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Login',
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
                'Login Gagal!',
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
              Swal.fire({
                title: 'Sukses!',
                text: 'Selamat, anda telah berhasil login.',
                icon: 'success',
                onClose: () => window.location = data.redirect_to
              });
            } else {
              Swal.fire({
                title: 'Login Gagal!',
                text: 'Username atau Password salah.',
                icon: 'error',
                onClose: () => form.reset()
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
</body>
</html>
