@extends('layouts.dashboard')
@section('title', 'Dashboard :: '. config('app.name'))
@section('heading', 'Dashboard')

@section('content')
<div class="card">
  <div class="card-body">
    <h2>Selamat Datang, {{ auth()->user()->name }}</h2>
  </div>
</div>
@endsection
