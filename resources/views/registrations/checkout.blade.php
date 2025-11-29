@extends('layouts.public')

@section('title', 'Checkout Pembayaran')

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
                Checkout Pembayaran
            </h1>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h3 class="text-xl font-bold text-black dark:text-white">Detail Pembayaran</h3>

                        <div class="mt-6 space-y-4">
                            <div class="flex justify-between">
                                <span>Event:</span>
                                <span class="font-medium">{{ $registration->event->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Harga:</span>
                                <span class="font-medium">Rp {{ number_format($registration->event->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Kode Referensi:</span>
                                <span class="font-medium">{{ $registration->payment_reference }}</span>
                            </div>
                            <div class="flex justify-between pt-4 border-t border-stroke">
                                <span class="font-bold">Total:</span>
                                <span class="font-bold">Rp {{ number_format($registration->event->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h4 class="text-lg font-bold text-black dark:text-white mb-4">Pembayaran Otomatis</h4>

                        <div class="space-y-4">
                            <div class="p-4 border border-stroke rounded-lg">
                                <h5 class="font-medium text-black dark:text-white">Midtrans Payment Gateway</h5>
                                <p class="mt-2 text-body-color dark:text-body-color-dark">Lakukan pembayaran melalui sistem pembayaran otomatis kami:</p>

                                <div class="mt-4">
                                    <a href="{{ route('transactions.create', $registration->event->id) }}"
                                        class="inline-flex items-center rounded-md bg-primary px-6 py-3 text-white hover:bg-opacity-90">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Bayar Sekarang
                                    </a>
                                </div>

                                <p class="mt-3 text-sm text-body-color dark:text-body-color-dark">
                                    Pembayaran aman melalui Midtrans. Tersedia berbagai metode pembayaran: transfer bank, e-wallet, dan kartu kredit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4 sticky top-6">
                        <h4 class="text-lg font-bold text-black dark:text-white">Ringkasan Pembayaran</h4>

                        <div class="mt-4 space-y-3">
                            <div class="flex justify-between">
                                <span>Event:</span>
                                <span>{{ Str::limit($registration->event->title, 20) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total:</span>
                                <span class="font-medium">Rp {{ number_format($registration->event->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-stroke pt-3">
                                <p class="text-sm text-body-color dark:text-body-color-dark">
                                    Setelah pembayaran berhasil, Anda akan menerima konfirmasi dan kode tiket secara otomatis.
                                </p>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('events.status', $registration->event->slug) }}"
                                    class="block w-full rounded bg-primary p-3 font-medium text-white text-center hover:bg-opacity-90">
                                    Lihat Status Pendaftaran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection