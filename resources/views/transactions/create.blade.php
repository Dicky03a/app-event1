@extends('layouts.app')

@section('title', 'Pembayaran Event')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Pembayaran Event
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium" href="{{ route('events.index') }}">Event /</a></li>
                    <li class="font-medium text-primary">Pembayaran</li>
                </ol>
            </nav>
        </div>

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Detail Pembayaran
                </h3>
            </div>
            <div class="p-6.5">
                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Event
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        {{ $event->title }}
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Lokasi
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        {{ $event->location }}
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Tanggal & Waktu
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        {{ $event->event_date->format('d M Y') }} - {{ $event->event_time->format('H:i') }}
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        Harga
                    </label>
                    <div class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-xl font-bold text-primary">
                        Rp {{ number_format($event->price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mb-4.5 pt-4">
                    <form action="{{ route('transactions.store', $event) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                            Lanjutkan ke Pembayaran
                        </button>
                    </form>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('events.show', $event) }}" class="text-primary hover:underline">
                        Kembali ke halaman event
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection