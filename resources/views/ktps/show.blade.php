@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Detail KTP</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('ktps.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    @if($ktp->foto)
                        <img src="{{ asset('storage/fotos/' . $ktp->foto) }}" alt="Foto KTP" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="border p-5 text-center text-muted">
                            <i class="bi bi-person-square" style="font-size: 100px;"></i>
                            <p>Tidak ada foto</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">NIK</div>
                        <div class="col-md-8">{{ $ktp->nik }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama</div>
                        <div class="col-md-8">{{ $ktp->nama }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tempat, Tanggal Lahir</div>
                        <div class="col-md-8">{{ $ktp->tempat_lahir }}, {{ \Carbon\Carbon::parse($ktp->tanggal_lahir)->format('d-m-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Umur</div>
                        <div class="col-md-8">{{ $ktp->umur }} tahun</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Jenis Kelamin</div>
                        <div class="col-md-8">{{ $ktp->jenis_kelamin }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Alamat</div>
                        <div class="col-md-8">{{ $ktp->alamat }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">RT/RW</div>
                        <div class="col-md-8">{{ $ktp->rt_rw }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Kelurahan/Desa</div>
                        <div class="col-md-8">{{ $ktp->kelurahan_desa }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Kecamatan</div>
                        <div class="col-md-8">{{ $ktp->kecamatan }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Agama</div>
                        <div class="col-md-8">{{ $ktp->agama }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status Perkawinan</div>
                        <div class="col-md-8">{{ $ktp->status_perkawinan }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Pekerjaan</div>
                        <div class="col-md-8">{{ $ktp->pekerjaan }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Kewarganegaraan</div>
                        <div class="col-md-8">{{ $ktp->kewarganegaraan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
