@extends('layouts.admin')

@section('title', 'Pendaftar Event: ' . $event->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4 class="card-title">Pendaftar Event: {{ $event->title }}</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('events.show', $event->slug) }}" class="btn btn-secondary">Kembali ke Event</a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peserta</th>
                                    <th>Email</th>
                                    <th>Status Pembayaran</th>
                                    <th>Referensi Pembayaran</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $index => $registration)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $registration->user->name }}</td>
                                    <td>{{ $registration->user->email }}</td>
                                    <td>
                                        @if($registration->payment_status == 'free')
                                            <span class="badge bg-success">Gratis</span>
                                        @elseif($registration->payment_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($registration->payment_status == 'paid')
                                            <span class="badge bg-success">Lunas</span>
                                        @endif
                                    </td>
                                    <td>{{ $registration->payment_reference ?? '-' }}</td>
                                    <td>{{ $registration->registered_at->format('d M Y H:i') }}</td>
                                    <td>
                                        @if($registration->payment_status == 'pending')
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#updatePaymentModal" data-id="{{ $registration->id }}">
                                                Update Pembayaran
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada pendaftar untuk event ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Payment Modal -->
<div class="modal fade" id="updatePaymentModal" tabindex="-1" aria-labelledby="updatePaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePaymentModalLabel">Update Status Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updatePaymentForm" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="payment_reference" class="form-label">Kode Referensi Pembayaran</label>
                        <input type="text" class="form-control" id="payment_reference" name="payment_reference" required>
                        <input type="hidden" id="registration_id" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Status Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updatePaymentModal = document.getElementById('updatePaymentModal');
    updatePaymentModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const registrationId = button.getAttribute('data-id');
        
        const form = document.getElementById('updatePaymentForm');
        const registrationIdInput = document.getElementById('registration_id');
        
        // Set the registration ID in the hidden input
        registrationIdInput.value = registrationId;
        
        // Update the form action URL
        form.action = '{{ url("registrations") }}/' + registrationId + '/update-payment';
    });
});
</script>
@endpush
@endsection