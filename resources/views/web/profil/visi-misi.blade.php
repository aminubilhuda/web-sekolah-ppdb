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
                    <div class="mb-0">
                        @if($profil && $profil->visi)
                            {!! $profil->visi !!}
                        @else
                            <p>Visi sekolah sedang dalam proses penyusunan.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3">Misi</h2>
                    <div class="mb-0">
                        @if($profil && $profil->misi)
                            {!! $profil->misi !!}
                        @else
                            <p>Misi sekolah sedang dalam proses penyusunan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 