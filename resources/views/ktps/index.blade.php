@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h2>Data KTP</h2>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group" role="group">
                <a href="{{ route('ktps.export.csv') }}" class="btn btn-success">Export CSV</a>
                <a href="{{ route('ktps.export.pdf') }}" class="btn btn-danger">Export PDF</a>
                
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('ktps.create') }}" class="btn btn-primary">Tambah KTP</a>
                    
                    <!-- Import CSV Button -->
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
                        Import CSV
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Umur</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ktps as $ktp)
                            <tr>
                                <td>{{ $ktp->nik }}</td>
                                <td>{{ $ktp->nama }}</td>
                                <td>{{ $ktp->tempat_lahir }}, {{ \Carbon\Carbon::parse($ktp->tanggal_lahir)->format('d-m-Y') }}</td>
                                <td>{{ $ktp->jenis_kelamin }}</td>
                                <td>{{ $ktp->alamat }}</td>
                                <td>{{ $ktp->umur }} tahun</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('ktps.show', $ktp->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('ktps.edit', $ktp->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            
                                            <form action="{{ route('ktps.destroy', $ktp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data KTP</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $ktps->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
@if(auth()->user()->role === 'admin')
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('ktps.import.csv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data KTP dari CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">File CSV</label>
                        <input type="file" class="form-control" id="file" name="file" required accept=".csv">
                        <div class="form-text">Format: NIK, Nama, Tempat Lahir, Tanggal Lahir, dll.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
