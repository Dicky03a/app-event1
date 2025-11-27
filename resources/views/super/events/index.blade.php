@extends('layouts.app')

@section('title', 'Event Pending')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Event Pending Approval
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li class="font-medium text-primary">Pending Events</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700 dark:bg-green-900/30 dark:text-green-400"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div
            class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">

            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                                Judul Event
                            </th>
                            <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                Organisasi
                            </th>
                            <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                Tanggal
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
                                    <p class="text-black dark:text-white">{{ $event->organization->name }}</p>
                                    <p class="text-sm text-gray-500">Oleh: {{ $event->creator->name }}</p>
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <p class="text-black dark:text-white">{{ $event->event_date->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $event->event_time->format('H:i') }}</p>
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <p
                                        class="inline-flex rounded-full bg-warning bg-opacity-10 px-3 py-1 text-sm font-medium text-warning">
                                        {{ ucfirst($event->status) }}
                                    </p>
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <div class="flex items-center space-x-3.5">
                                        <a href="{{ route('super.events.show', $event) }}" class="hover:text-primary">
                                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.99981 14.8219C5.84981 14.8219 2.94981 12.9094 1.64981 9.98438C1.59356 9.84375 1.59356 9.675 1.64981 9.53437C2.94981 6.60938 5.84981 4.69688 8.99981 4.69688C12.1498 4.69688 15.0498 6.60938 16.3498 9.53437C16.4061 9.675 16.4061 9.84375 16.3498 9.98438C15.0498 12.9094 12.1498 14.8219 8.99981 14.8219ZM8.99981 6.38438C7.25606 6.38438 5.84981 7.79063 5.84981 9.53438C5.84981 11.2781 7.25606 12.6844 8.99981 12.6844C10.7436 12.6844 12.1498 11.2781 12.1498 9.53438C12.1498 7.79063 10.7436 6.38438 8.99981 6.38438Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada event yang menunggu persetujuan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection