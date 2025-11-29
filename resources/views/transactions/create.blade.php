@extends('layouts.public')

@section('title', 'Pembayaran Event')

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
                Pembayaran Event
            </h1>
            
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h3 class="text-xl font-bold text-black dark:text-white">Detail Pembayaran</h3>
                        
                        <div class="mt-6 space-y-4">
                            <div class="flex justify-between">
                                <span>Event:</span>
                                <span class="font-medium">{{ $event->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Deskripsi:</span>
                                <span class="font-medium">{{ Str::limit($event->description, 100) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tanggal:</span>
                                <span class="font-medium">{{ $event->event_date->format('d F Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Waktu:</span>
                                <span class="font-medium">{{ $event->event_time }} WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Lokasi:</span>
                                <span class="font-medium">{{ $event->location }}</span>
                            </div>
                            <div class="flex justify-between pt-4 border-t border-stroke text-lg font-bold">
                                <span>Total Pembayaran:</span>
                                <span class="text-success">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h4 class="text-lg font-bold text-black dark:text-white mb-4">Konfirmasi Pembayaran</h4>
                        
                        <div class="space-y-4">
                            <p class="text-body-color dark:text-body-color-dark">
                                Anda akan diarahkan ke halaman pembayaran yang aman melalui Midtrans.
                                Setelah pembayaran selesai, status pendaftaran Anda akan diperbarui secara otomatis.
                            </p>
                            
                            <form method="POST" action="{{ route('transactions.store', $event->id) }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center rounded-md bg-success px-6 py-3 text-white hover:bg-opacity-90">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Konfirmasi & Bayar Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-1">
                    <div class="rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h4 class="text-lg font-bold text-black dark:text-white">Keamanan Pembayaran</h4>
                        
                        <div class="mt-4 space-y-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 text-sm text-body-color dark:text-body-color-dark">
                                    <p>Proses pembayaran dilindungi dengan enkripsi SSL</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 text-sm text-body-color dark:text-body-color-dark">
                                    <p>Dikelola oleh Midtrans - payment gateway terpercaya</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 text-sm text-body-color dark:text-body-color-dark">
                                    <p>Berbagai pilihan metode pembayaran tersedia</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <div class="flex items-center justify-center p-4 bg-gray-100 dark:bg-boxdark rounded-lg">
                                <img src="https://i.pinimg.com/originals/25/8c/92/258c92c6d9df987f6f23f470e4d1c0c4.png" alt="Midtrans" class="h-8">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection