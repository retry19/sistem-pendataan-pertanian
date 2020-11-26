@extends('layouts.dashboard')
@section('title', 'Laporan Kepemilikan Hewan Ternak :: '. config('app.name'))
@section('heading', 'Laporan Kepemilikan Hewan Ternak')

@section('content')
<div class="card">
  <form action="{{ route('laporan.kepemilikan-hewan-ternak.store') }}" method="POST">
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
    </div>
    <div class="card-footer">
      <div class="text-right">
        <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> Download Laporan</button>
      </div>
    </div>
  </form>
</div>
@endsection
