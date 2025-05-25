@extends('admin.layouts.app')

@section('title', 'Data PPDB')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data PPDB</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.ppdb.export') }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Pendaftaran</th>
                                    <th>Nama Lengkap</th>
                                    <th>NISN</th>
                                    <th>Asal Sekolah</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ppdbs as $ppdb)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ppdb->nomor_pendaftaran }}</td>
                                    <td>{{ $ppdb->nama_lengkap }}</td>
                                    <td>{{ $ppdb->nisn }}</td>
                                    <td>{{ $ppdb->asal_sekolah }}</td>
                                    <td>{{ $ppdb->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $ppdb->status == 'Diterima' ? 'success' : ($ppdb->status == 'Ditolak' ? 'danger' : 'warning') }}">
                                            {{ $ppdb->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 