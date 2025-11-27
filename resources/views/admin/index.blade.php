@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Admin Dashboard
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium text-blue-600 hover:text-blue-700"
                            href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Organization Info -->
        @if(auth()->user()->organization)
            <div class="rounded-lg border border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600 p-6 shadow-sm mb-6">
                <h3 class="text-xl font-bold text-white mb-2">
                    {{ auth()->user()->organization->name }}
                </h3>
                <p class="text-blue-100">
                    {{ auth()->user()->organization->description ?? 'Kelola organisasi Anda dengan mudah' }}
                </p>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5 mb-6">
            <!-- Total Events -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Event</h4>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->organization ? auth()->user()->organization->events()->count() : 0 }}
                        </span>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/20">
                        <svg class="fill-purple-600 dark:fill-purple-400" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Members -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Anggota</h4>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->organization ? auth()->user()->organization->users()->count() : 0 }}
                        </span>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                        <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Certificates -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sertifikat</h4>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->organization ? auth()->user()->organization->certificates()->count() : 0 }}
                        </span>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/20">
                        <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Events -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Event Pending</h4>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->organization ? auth()->user()->organization->events()->where('status', 'pending')->count() : 0 }}
                        </span>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100 dark:bg-orange-900/20">
                        <svg class="fill-orange-600 dark:fill-orange-400" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800 mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                Selamat Datang, {{ auth()->user()->name }}!
            </h3>
            <p class="text-gray-600 dark:text-gray-400">
                Anda login sebagai <span class="font-semibold text-blue-600 dark:text-blue-400">Administrator
                    Organisasi</span>.
                Kelola event, sertifikat, dan anggota organisasi Anda.
            </p>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.events.index') }}"
                    class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/20">
                        <svg class="fill-purple-600 dark:fill-purple-400" width="20" height="20" viewBox="0 0 24 24">
                            <path
                                d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Kelola Event</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Create and manage events</p>
                    </div>
                </a>

                <a href="{{ route('admin.certificates.index') }}"
                    class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/20">
                        <svg class="fill-blue-600 dark:fill-blue-400" width="20" height="20" viewBox="0 0 24 24">
                            <path
                                d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Kelola Sertifikat</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Issue certificates</p>
                    </div>
                </a>

                <a href="{{ route('admin.registrations.index') }}"
                    class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                        <svg class="fill-green-600 dark:fill-green-400" width="20" height="20" viewBox="0 0 24 24">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Daftar Ulang</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Manage registrations</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection