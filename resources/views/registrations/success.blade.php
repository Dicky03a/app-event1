@extends('layouts.public')

@section('title', 'Pendaftaran Berhasil')

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
            <div class="text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-success/10">
                    <svg class="h-8 w-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h1 class="mt-4 text-2xl font-bold text-black dark:text-white sm:text-3xl">
                    Pendaftaran Berhasil!
                </h1>
                
                <p class="mt-2 text-body-color dark:text-body-color-dark">
                    Terima kasih telah mendaftar pada event berikut:
                </p>
                
                <div class="mt-6 rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                    <h3 class="text-xl font-bold text-black dark:text-white">{{ $event->title }}</h3>
                    <div class="mt-4 space-y-2">
                        <p><span class="font-medium">Tanggal:</span> {{ $event->event_date->format('d F Y') }}</p>
                        <p><span class="font-medium">Waktu:</span> {{ $event->event_time }} WIB</p>
                        <p><span class="font-medium">Lokasi:</span> {{ $event->location }}</p>
                        <p><span class="font-medium">Status Pembayaran:</span>
                            <span class="inline-flex items-center rounded-full bg-success/10 px-3 py-1 text-sm font-medium text-success">
                                {{ ucfirst($registration->payment_status) }}
                            </span>
                        </p>
                        @if($registration->ticket_code)
                            <p><span class="font-medium">Kode Tiket:</span>
                                <span class="font-mono font-bold text-primary">{{ $registration->ticket_code }}</span>
                            </p>
                        @endif
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('events.status', $event->slug) }}" 
                        class="inline-flex items-center rounded-md bg-primary px-6 py-3 text-white hover:bg-opacity-90">
                        Lihat Status Pendaftaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection