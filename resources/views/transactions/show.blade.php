@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detail Transaksi
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium" href="{{ route('events.index') }}">Event /</a></li>
                    <li class="font-medium text-primary">Transaksi</li>
                </ol>
            </nav>
        </div>

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Informasi Transaksi
                </h3>
            </div>
            <div class="p-6.5">
                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        ID Transaksi
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        {{ $transaction->id }}
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Event
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        {{ $transaction->event->title }}
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Harga
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Status Pembayaran
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        @if($transaction->payment_status === 'pending')
                            <span class="inline-flex items-center rounded-full bg-warning bg-opacity-10 px-3 py-1 text-sm font-medium text-warning">
                                Pending
                            </span>
                        @elseif($transaction->payment_status === 'paid')
                            <span class="inline-flex items-center rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">
                                Dibayar
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">
                                Gagal
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Tanggal Transaksi
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        {{ $transaction->created_at->format('d M Y H:i') }}
                    </div>
                </div>

                @if($transaction->payment_status === 'pending')
                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Aksi
                        </label>
                        <div class="w-full">
                            <a href="{{ $transaction->payment_url }}" 
                               class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                Bayar Sekarang
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection