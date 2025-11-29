@extends('layouts.public')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="mx-auto max-w-screen-xl p-4 md:p-6 2xl:p-10">
    <div class="mb-6">
        <a href="{{ route('events.index') }}" class="flex items-center gap-2 text-primary hover:underline">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.7083 15.8333L6.875 10L12.7083 4.16666" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Kembali ke Daftar Event
        </a>
    </div>

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="p-6 sm:p-10">
            <h1 class="mb-6 text-2xl font-bold text-black dark:text-white sm:text-3xl">
                Status Pendaftaran
            </h1>
            
            <div class="rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                <h3 class="text-xl font-bold text-black dark:text-white">{{ $event->title }}</h3>
                
                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <h4 class="font-medium text-black dark:text-white">Detail Pendaftaran</h4>
                        <div class="mt-3 space-y-2">
                            <p><span class="font-medium">Tanggal Pendaftaran:</span> {{ $registration->registered_at->format('d F Y, H:i') }}</p>
                            <p><span class="font-medium">Status Pembayaran:</span> 
                                @if($registration->payment_status == 'free')
                                    <span class="inline-flex items-center rounded-full bg-success/10 px-3 py-1 text-sm font-medium text-success">
                                        Gratis
                                    </span>
                                @elseif($registration->payment_status == 'pending')
                                    <span class="inline-flex items-center rounded-full bg-warning/10 px-3 py-1 text-sm font-medium text-warning">
                                        Menunggu Pembayaran
                                    </span>
                                @elseif($registration->payment_status == 'paid')
                                    <span class="inline-flex items-center rounded-full bg-success/10 px-3 py-1 text-sm font-medium text-success">
                                        Pembayaran Sukses
                                    </span>
                                @endif
                            </p>
                            @if($registration->payment_reference)
                                <p><span class="font-medium">Kode Referensi:</span> {{ $registration->payment_reference }}</p>
                            @endif
                            @if($registration->ticket_code)
                                <p><span class="font-medium">Kode Tiket:</span>
                                    <span class="font-mono font-bold text-primary">{{ $registration->ticket_code }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-black dark:text-white">Detail Event</h4>
                        <div class="mt-3 space-y-2">
                            <p><span class="font-medium">Tanggal:</span> {{ $event->event_date->format('d F Y') }}</p>
                            <p><span class="font-medium">Waktu:</span> {{ $event->event_time }} WIB</p>
                            <p><span class="font-medium">Lokasi:</span> {{ $event->location }}</p>
                            @if($event->price)
                                <p><span class="font-medium">Harga:</span> Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                            @else
                                <p><span class="font-medium">Harga:</span> Gratis</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    @if($registration->payment_status == 'pending')
                        <a href="{{ route('payment.checkout', $registration->id) }}" 
                            class="inline-flex items-center rounded-md bg-primary px-6 py-3 text-white hover:bg-opacity-90 mr-4">
                            Selesaikan Pembayaran
                        </a>
                    @endif
                    <a href="{{ route('events.show', $event->slug) }}" 
                        class="inline-flex items-center rounded-md bg-secondary px-6 py-3 text-white hover:bg-opacity-90">
                        Kembali ke Event
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection