@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Aktivitas Pengguna</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pengguna</th>
                            <th>Aktivitas</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $index => $activity)
                            <tr>
                                <td>{{ $activities->firstItem() + $index }}</td>
                                <td>{{ $activity->user->name }} ({{ $activity->user->role }})</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada aktivitas pengguna</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
