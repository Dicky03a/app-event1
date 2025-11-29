@extends('layouts.public')

@section('title', 'Detail Transaksi')

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
                Detail Transaksi
            </h1>
            
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h3 class="text-xl font-bold text-black dark:text-white">Informasi Transaksi</h3>
                        
                        <div class="mt-6 space-y-4">
                            <div class="flex justify-between">
                                <span>ID Transaksi:</span>
                                <span class="font-medium">{{ $transaction->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Event:</span>
                                <span class="font-medium">{{ $transaction->event->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jumlah Pembayaran:</span>
                                <span class="font-medium text-success">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Status Pembayaran:</span>
                                <span class="font-medium">
                                    @if($transaction->payment_status == 'paid')
                                        <span class="inline-flex items-center rounded-full bg-success/10 px-3 py-1 text-sm font-medium text-success">
                                            Lunas
                                        </span>
                                    @elseif($transaction->payment_status == 'pending')
                                        <span class="inline-flex items-center rounded-full bg-warning/10 px-3 py-1 text-sm font-medium text-warning">
                                            Menunggu Pembayaran
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-danger/10 px-3 py-1 text-sm font-medium text-danger">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tanggal Transaksi:</span>
                                <span class="font-medium">{{ $transaction->created_at->format('d F Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($transaction->payment_url && $transaction->payment_status == 'pending')
                    <div class="mt-6 rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h4 class="text-lg font-bold text-black dark:text-white mb-4">Lanjutkan Pembayaran</h4>
                        
                        <div class="space-y-4">
                            <p class="text-body-color dark:text-body-color-dark">
                                Klik tombol di bawah untuk melanjutkan proses pembayaran Anda.
                            </p>
                            
                            <a href="{{ $transaction->payment_url }}" 
                                class="inline-flex items-center rounded-md bg-success px-6 py-3 text-white hover:bg-opacity-90">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Lanjutkan Pembayaran
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="lg:col-span-1">
                    <div class="rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h4 class="text-lg font-bold text-black dark:text-white">Ringkasan</h4>
                        
                        <div class="mt-4 space-y-3">
                            <div class="flex justify-between">
                                <span>Event:</span>
                                <span>{{ Str::limit($transaction->event->title, 20) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total:</span>
                                <span class="font-medium">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-stroke pt-3">
                                <p class="text-sm text-body-color dark:text-body-color-dark">
                                    Status pembayaran akan diperbarui secara otomatis setelah pembayaran berhasil diproses.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection