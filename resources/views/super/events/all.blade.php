@extends('layouts.app')

@section('title', 'All Events')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Manage Events
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li class="font-medium text-primary">Manage Events</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700 dark:bg-green-900/30 dark:text-green-400"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter and Search Section -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('super.events.all') }}" 
                   class="px-4 py-2 rounded border {{ !request('status') ? 'bg-blue-500 text-white border-blue-500' : 'bg-white text-black border-gray-300 dark:bg-boxdark dark:text-white dark:border-strokedark'}}">
                    All
                </a>
                <a href="{{ route('super.events.all', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded border {{ request('status') == 'pending' ? 'bg-yellow-500 text-white border-yellow-500' : 'bg-white text-black border-gray-300 dark:bg-boxdark dark:text-white dark:border-strokedark'}}">
                    Pending
                </a>
                <a href="{{ route('super.events.all', ['status' => 'published']) }}" 
                   class="px-4 py-2 rounded border {{ request('status') == 'published' ? 'bg-green-500 text-white border-green-500' : 'bg-white text-black border-gray-300 dark:bg-boxdark dark:text-white dark:border-strokedark'}}">
                    Approved
                </a>
                <a href="{{ route('super.events.all', ['status' => 'rejected']) }}" 
                   class="px-4 py-2 rounded border {{ request('status') == 'rejected' ? 'bg-red-500 text-white border-red-500' : 'bg-white text-black border-gray-300 dark:bg-boxdark dark:text-white dark:border-strokedark'}}">
                    Rejected
                </a>
            </div>
            
            <!-- Search Form -->
            <form method="GET" action="{{ route('super.events.all') }}" class="w-full sm:w-auto">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search events, organizations, creators..." 
                           class="w-full rounded-lg border border-stroke bg-transparent px-5 py-2.5 pl-10 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                    <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2">
                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.1 1.5C9.7398 1.5 11.2789 2.1508 12.4562 3.32813C13.6335 4.50546 14.2843 6.04454 14.2843 7.68433C14.2843 9.32412 13.6335 10.8632 12.4562 12.0405C11.2789 13.2178 9.7398 13.8686 8.1 13.8686C6.4602 13.8686 4.92113 13.2178 3.7438 12.0405C2.56647 10.8632 1.91565 9.32412 1.91565 7.68433C1.91565 6.04454 2.56647 4.50546 3.7438 3.32813C4.92113 2.1508 6.4602 1.5 8.1 1.5ZM8.1 2.7C7.03672 2.7 6.02063 3.10406 5.28633 3.83836C4.55203 4.57266 4.14795 5.58875 4.14795 6.65203C4.14795 7.71531 4.55203 8.7314 5.28633 9.4657C6.02063 10.2000 7.03672 10.6041 8.1 10.6041C9.16328 10.6041 10.1794 10.2000 10.9137 9.4657C11.6480 8.7314 12.0520 7.71531 12.0520 6.65203C12.0520 5.58875 11.6480 4.57266 10.9137 3.83836C10.1794 3.10406 9.16328 2.7 8.1 2.7ZM11.855 11.855C11.555 12.1266 11.1938 12.3258 10.7991 12.4369L13.275 14.9128C13.3861 14.5181 13.5853 14.1569 13.857 13.8569L11.855 11.855Z" fill="" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
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
                                    @if($event->status === 'pending')
                                        <p class="inline-flex rounded-full bg-warning bg-opacity-10 px-3 py-1 text-sm font-medium text-warning">
                                            {{ ucfirst($event->status) }}
                                        </p>
                                    @elseif($event->status === 'published')
                                        <p class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">
                                            Approved
                                        </p>
                                    @elseif($event->status === 'rejected')
                                        <p class="inline-flex rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">
                                            {{ ucfirst($event->status) }}
                                        </p>
                                    @else
                                        <p class="inline-flex rounded-full bg-secondary bg-opacity-10 px-3 py-1 text-sm font-medium text-black">
                                            {{ ucfirst($event->status) }}
                                        </p>
                                    @endif
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
                                    @if(request('search'))
                                        Tidak ditemukan event yang sesuai dengan pencarian "{{ request('search') }}".
                                    @else
                                        Tidak ada event yang ditemukan.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection