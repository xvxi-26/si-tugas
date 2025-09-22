@extends('mahasiswa.layouts.app')
<title>SI - TUGAS - Mahasiswa</title>
@section('content')
<div class="d-flex gap-4">
    <div class="card w-100 text-bg-primary mb-3" style="max-width: 18rem;">
        <div class="card-header">Data User</div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <span>Selamat Datang <p class="fw-bold fs-6">{{auth()->guard('mahasiswa')->user()->nama}}</p></span>
            <i class="bi bi-person-circle" style="font-size: 50px"></i>
          </div>
        </div>
      </div>
      <a href="{{ Route('telegram.register') }}" class="btn btn-sm btn-info d-flex align-items-center gap-2 shadow-sm mb-3" style="font-weight: bold;">
        <i class="bi bi-telegram p-0" style="font-size: 24px;"></i>
        Hubungkan Telegram
    </a>

</div>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endpush
