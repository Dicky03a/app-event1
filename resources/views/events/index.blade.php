@extends('layouts.app')

@section('title', 'Daftar Event')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Daftar Event
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li class="font-medium text-primary">Event</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700 dark:bg-green-900/30 dark:text-green-400"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 px-6 py-5 text-base text-red-700 dark:bg-red-900/30 dark:text-red-400"
                role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div
            class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('admin.events.create') }}"
                    class="inline-flex items-center justify-center rounded-md bg-primary px-10 py-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                    <span>
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 4.16666V15.8333M4.16666 10H15.8333" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="ml-2">Buat Event</span>
                </a>
            </div>

            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                                Judul Event
                            </th>
                            <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                Tanggal
                            </th>
                            <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                                Lokasi
                            </th>
                            <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                                Status
                            </th>
                            <th class="px-4 py-4 font-medium text-black dark:text-white">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                                        <tr>
                                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                                <h5 class="font-medium text-black dark:text-white">{{ $event->title }}</h5>
                                            </td>
                                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <p class="text-black dark:text-white">{{ $event->event_date->format('d M Y') }}</p>
                                                <p class="text-sm text-gray-500">{{ $event->event_time->format('H:i') }}</p>
                                            </td>
                                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <p class="text-black dark:text-white">{{ $event->location }}</p>
                                            </td>
                                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <p
                                                    class="inline-flex rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium 
                                                    {{ $event->status === 'published' ? 'bg-success text-success' :
                            ($event->status === 'rejected' ? 'bg-danger text-danger' : 'bg-warning text-warning') }}">
                                                    {{ ucfirst($event->status) }}
                                                </p>
                                                @if($event->status === 'rejected' && $event->rejection_reason)
                                                    <p class="text-xs text-danger mt-1">Alasan: {{ $event->rejection_reason }}</p>
                                                @endif
                                            </td>
                                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                                <div class="flex items-center space-x-3.5">
                                                    <a href="{{ route('admin.events.show', $event) }}" class="hover:text-primary">
                                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M8.99981 14.8219C5.84981 14.8219 2.94981 12.9094 1.64981 9.98438C1.59356 9.84375 1.59356 9.675 1.64981 9.53437C2.94981 6.60938 5.84981 4.69688 8.99981 4.69688C12.1498 4.69688 15.0498 6.60938 16.3498 9.53437C16.4061 9.675 16.4061 9.84375 16.3498 9.98438C15.0498 12.9094 12.1498 14.8219 8.99981 14.8219ZM8.99981 6.38438C7.25606 6.38438 5.84981 7.79063 5.84981 9.53438C5.84981 11.2781 7.25606 12.6844 8.99981 12.6844C10.7436 12.6844 12.1498 11.2781 12.1498 9.53438C12.1498 7.79063 10.7436 6.38438 8.99981 6.38438Z"
                                                                fill="" />
                                                        </svg>
                                                    </a>
                                                    @if($event->status !== 'published')
                                                        <a href="{{ route('admin.events.edit', $event) }}" class="hover:text-primary">
                                                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M13.7531 2.47501L15.525 4.24689C15.8906 4.61251 15.8906 5.20314 15.525 5.56876L14.6812 6.41251L11.5875 3.31876L12.4312 2.47501C12.7969 2.10939 13.3875 2.10939 13.7531 2.47501ZM10.7437 4.16251L13.8375 7.25626L5.11875 15.975L2.025 15.975L2.025 12.8813L10.7437 4.16251Z"
                                                                    fill="" />
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                                            class="inline-block"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="hover:text-danger">
                                                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.7531 2.47501L15.525 4.24689C15.8906 4.61251 15.8906 5.20314 15.525 5.56876L14.6812 6.41251L11.5875 3.31876L12.4312 2.47501C12.7969 2.10939 13.3875 2.10939 13.7531 2.47501ZM10.7437 4.16251L13.8375 7.25626L5.11875 15.975L2.025 15.975L2.025 12.8813L10.7437 4.16251Z"
                                                                        fill="" />
                                                                    <path
                                                                        d="M14.0625 3.9375H3.9375C3.50625 3.9375 3.15 3.58125 3.15 3.15C3.15 2.71875 3.50625 2.3625 3.9375 2.3625H14.0625C14.4937 2.3625 14.85 2.71875 14.85 3.15C14.85 3.58125 14.4937 3.9375 14.0625 3.9375Z"
                                                                        fill="" />
                                                                    <path
                                                                        d="M12.9375 14.625H5.0625C4.63125 14.625 4.275 14.2687 4.275 13.8375V5.0625H13.725V13.8375C13.725 14.2687 13.3687 14.625 12.9375 14.625Z"
                                                                        fill="" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada event yang dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection