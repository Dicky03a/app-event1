@extends('layouts.public')

@section('title', $event->title)

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
            <div class="mb-8 border-b border-stroke pb-8 dark:border-strokedark">
                <h1 class="mb-4 text-3xl font-bold text-black dark:text-white sm:text-4xl">
                    {{ $event->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex items-center gap-2 text-body-color dark:text-body-color-dark">
                        <svg class="fill-current text-primary" width="20" height="20" viewBox="0 0 24 24">
                            <path
                                d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2.9 2-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z" />
                        </svg>
                        <span>{{ $event->event_date->format('l, d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-body-color dark:text-body-color-dark">
                        <svg class="fill-current text-primary" width="20" height="20" viewBox="0 0 24 24">
                            <path
                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                        </svg>
                        <span>{{ $event->event_time }} WIB</span>
                    </div>
                    <div class="flex items-center gap-2 text-body-color dark:text-body-color-dark">
                        <svg class="fill-current text-primary" width="20" height="20" viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <h3 class="mb-4 text-xl font-bold text-black dark:text-white">Deskripsi Event</h3>
                    <div class="text-body-color dark:text-body-color-dark whitespace-pre-line leading-relaxed">
                        {{ $event->description }}
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="rounded-sm border border-stroke bg-gray-50 p-6 dark:border-strokedark dark:bg-meta-4">
                        <h4 class="mb-4 text-lg font-bold text-black dark:text-white">Diselenggarakan Oleh</h4>
                        <div class="flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-primary flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($event->organization->name, 0, 1) }}
                            </div>
                            <div>
                                <h5 class="font-semibold text-black dark:text-white">{{ $event->organization->name }}
                                </h5>
                                <p class="text-sm text-gray-500">Penyelenggara Terpercaya</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            @auth
                                @if($event->price == null || $event->price == 0 || $event->is_free)
                                    <form action="{{ route('events.register', $event->slug) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                            Daftar Gratis
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('events.register', $event->slug) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                            Daftar & Bayar (Rp {{ number_format($event->price, 0, ',', '.') }})
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                    Login untuk Daftar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection