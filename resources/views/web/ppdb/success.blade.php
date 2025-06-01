@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - PPDB')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="mb-4">Pendaftaran Berhasil!</h2>
                    <p class="mb-4">Terima kasih telah mendaftar di PPDB kami. Silahkan cek email Anda untuk informasi selanjutnya.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('web.ppdb.status') }}" class="btn btn-primary">Cek Status Pendaftaran</a>
                        <a href="{{ route('web.home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 