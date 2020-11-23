@extends('layouts.dashboard')
@section('title', 'Permissions :: '. config('app.name'))
@section('heading', 'Permissions')

@section('content')
<div class="row">
  <div class="col-md-7">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Daftar Permissions</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" id="btn-open-card-add">
            <i class="fas fa-plus"></i>&nbsp; Tambah Permission
          </button>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover" id="table">
          <thead>
            <tr class="text-center">
              <th width="30px">No</th>
              <th>Judul</th>
              <th width="100px">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
