@extends('layouts.dashboard')
@section('title', 'Kelola Kuartal :: '. config('app.name'))
@section('heading', 'Kelola Kuartal')

@section('content')
<div class="row">
  <div class="col-md-7">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Daftar Kuartal</h5>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover w-100">
          <thead>
            <tr class="text-center">
              <th>Kuartal</th>
              <th class="w-25">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($quarters as $quarter)
            <tr class="text-center">
              <td>{{ $quarter->section }}</td>
              <td>
                @if (!$quarter->is_active)
                <a href="{{ route('quarters.active', $quarter->id) }}" class="btn btn-sm btn-info">Aktifkan</a>
                @else
                <span class="text-bold text-success">Sedang Aktif</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
