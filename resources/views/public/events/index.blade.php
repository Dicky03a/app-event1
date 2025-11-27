@extends('layouts.public')

@section('title', 'Daftar Event')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-10 text-center">
            <h2 class="mb-4 text-3xl font-bold text-black dark:text-white">
                Event Terbaru
            </h2>
            <p class="text-body-color dark:text-body-color-dark">
                Temukan event menarik yang akan datang dan jangan lewatkan keseruannya!
            </p>
        </div>

        <div class="grid grid-cols-1 gap-7.5 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($events as $event)
                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <span class="rounded bg-primary py-1 px-3 text-xs font-medium text-white">
                                {{ $event->event_date->format('d M Y') }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $event->event_time->format('H:i') }} WIB
                            </span>
                        </div>

                        <h4 class="mb-3 text-xl font-semibold text-black dark:text-white hover:text-primary">
                            <a href="{{ route('events.show', $event->slug) }}">
                                {{ $event->title }}
                            </a>
                        </h4>

                        <p class="mb-4 text-sm line-clamp-3">
                            {{ Str::limit($event->description, 100) }}
                        </p>

                        <div class="flex items-center justify-between border-t border-stroke pt-4 dark:border-strokedark">
                            <div class="flex items-center gap-2">
                                <svg class="fill-current text-primary" width="16" height="16" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                </svg>
                                <span class="text-sm font-medium">{{ $event->location }}</span>
                            </div>
                            <span class="text-xs text-gray-500">
                                By {{ $event->organization->name }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-lg text-gray-500">Belum ada event yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $events->links() }}
        </div>
    </div>
@endsection