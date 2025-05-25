@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Siswa</h3>
                    <div class="card-tools">
                        <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($siswa->foto)
                                <img src="{{ Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}" class="img-fluid rounded" style="max-width: 200px;">
                            @else
                                <img src="{{ asset('img/default-avatar.png') }}" alt="{{ $siswa->nama }}" class="img-fluid rounded" style="max-width: 200px;">
                            @endif
                            <h4 class="mt-3">{{ $siswa->nama }}</h4>
                            <p class="text-muted">
                                @if($siswa->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Data Pribadi</h5>
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="150">NIS</th>
                                            <td>{{ $siswa->nis ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NISN</th>
                                            <td>{{ $siswa->nisn ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td>{{ $siswa->nik ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tempat Lahir</th>
                                            <td>{{ $siswa->tempat_lahir ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Agama</th>
                                            <td>{{ $siswa->agama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $siswa->alamat ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Data Akademik</h5>
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="150">Kelas</th>
                                            <td>{{ $siswa->kelas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jurusan</th>
                                            <td>{{ $siswa->jurusan }}</td>
                                        </tr>
                                    </table>

                                    <h5 class="mt-4">Data Orang Tua</h5>
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="150">Nama Ayah</th>
                                            <td>{{ $siswa->nama_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK Ayah</th>
                                            <td>{{ $siswa->nik_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan Ayah</th>
                                            <td>{{ $siswa->pekerjaan_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. HP Ayah</th>
                                            <td>{{ $siswa->no_hp_ayah ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Ibu</th>
                                            <td>{{ $siswa->nama_ibu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK Ibu</th>
                                            <td>{{ $siswa->nik_ibu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan Ibu</th>
                                            <td>{{ $siswa->pekerjaan_ibu ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. HP Ibu</th>
                                            <td>{{ $siswa->no_hp_ibu ?? '-' }}</td>
                                        </tr>
                                    </table>

                                    <h5 class="mt-4">Data Wali</h5>
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="150">Nama Wali</th>
                                            <td>{{ $siswa->nama_wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK Wali</th>
                                            <td>{{ $siswa->nik_wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan Wali</th>
                                            <td>{{ $siswa->pekerjaan_wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. HP Wali</th>
                                            <td>{{ $siswa->no_hp_wali ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hubungan</th>
                                            <td>{{ $siswa->hubungan_wali ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 