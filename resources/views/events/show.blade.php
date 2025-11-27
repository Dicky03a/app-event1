@extends('layouts.app')

@section('title', 'Detail Event')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detail Event
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium" href="{{ route('admin.events.index') }}">Event /</a></li>
                    <li class="font-medium text-primary">Detail</li>
                </ol>
            </nav>
        </div>

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Informasi Event
                </h3>
            </div>
            <div class="p-6.5">
                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white font-bold">
                        Judul Event
                    </label>
                    <p class="text-black dark:text-white">{{ $event->title }}</p>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white font-bold">
                        Deskripsi
                    </label>
                    <div class="text-black dark:text-white whitespace-pre-line">{{ $event->description }}</div>
                </div>

                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white font-bold">
                            Tanggal
                        </label>
                        <p class="text-black dark:text-white">{{ $event->event_date->format('d F Y') }}</p>
                    </div>

                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white font-bold">
                            Waktu
                        </label>
                        <p class="text-black dark:text-white">{{ $event->event_time->format('H:i') }} WIB</p>
                    </div>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white font-bold">
                        Lokasi
                    </label>
                    <p class="text-black dark:text-white">{{ $event->location }}</p>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white font-bold">
                        Status
                    </label>
                    <p class="inline-flex rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium 
                        {{ $event->status === 'published' ? 'bg-success text-success' :
        ($event->status === 'rejected' ? 'bg-danger text-danger' : 'bg-warning text-warning') }}">
                        {{ ucfirst($event->status) }}
                    </p>
                    @if($event->status === 'rejected' && $event->rejection_reason)
                        <p class="text-danger mt-2"><strong>Alasan Penolakan:</strong> {{ $event->rejection_reason }}</p>
                    @endif
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.events.index') }}"
                        class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                        Kembali
                    </a>
                    @if($event->status !== 'published')
                        <a href="{{ route('admin.events.edit', $event) }}"
                            class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90">
                            Edit Event
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection