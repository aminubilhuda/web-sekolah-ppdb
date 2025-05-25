@extends('layouts.app')

@section('title', 'Visi & Misi - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">Visi & Misi</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">Visi</h2>
                    <p class="mb-0">
                        {{ $profil->visi ?? 'Visi sekolah belum tersedia' }}
                    </p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3">Misi</h2>
                    <p class="mb-0">
                        {{ $profil->misi ?? 'Misi sekolah belum tersedia' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 