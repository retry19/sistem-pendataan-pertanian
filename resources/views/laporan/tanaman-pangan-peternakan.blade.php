@extends('layouts.dashboard')
@section('title', 'Laporan Tanaman Pangan dan Peternakan :: '. config('app.name'))
@section('heading', 'Laporan Tanaman Pangan dan Peternakan')

@section('content')
<div class="card">
  <form action="{{ route('laporan.tanaman-pangan-peternakan.store') }}" method="POST">
    @csrf
    <div class="card-body">
      <div class="form-group row">
        <label for="tahun" class="col-md-2 col-form-label">Tahun <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <input type="text" name="tahun" class="form-control form-control-sm w-25" id="tahun">
          @error('tahun')
          <small class="text-danger" id="error-tahun">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label for="kuartal_id" class="col-md-2 col-form-label">Kuartal <span class="text-danger">*</span></label>
        <div class="col-md-10">
          <select name="kuartal_id" id="kuartal_id" class="form-control select2bs4 form-control-sm" style="width: 25%">
            <option value="">--- Pilih kuartal ---</option>
            @foreach ($quarters as $q)
            <option value="{{ $q->id }}">{{ $q->section }}</option>
            @endforeach
          </select>
          @error('kuartal_id')
          <small class="text-danger" id="error-kuartal_id">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label for="kepala_desa" class="col-md-2 col-form-label">Kepala Desa</label>
        <div class="col-md-10">
          <input type="text" name="kepala_desa" class="form-control form-control-sm w-50" id="kepala_desa">
          @error('kepala_desa')
          <small class="text-danger" id="error-kepala_desa">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label for="kaur_ekbang" class="col-md-2 col-form-label">Kaur Ekbang</label>
        <div class="col-md-10">
          <input type="text" name="kaur_ekbang" class="form-control form-control-sm w-50" id="kaur_ekbang">
          @error('kaur_ekbang')
          <small class="text-danger" id="error-kaur_ekbang">{{ $message }}</small>
          @enderror
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="text-right">
        <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> Download Laporan</button>
      </div>
    </div>
  </form>
</div>
@endsection
