@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Dashboard
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

        <!-- Welcome Card -->
        <div class="rounded-lg border border-gray-200 bg-gradient-to-r from-blue-500 to-purple-600 p-8 shadow-sm mb-6">
            <h3 class="text-2xl font-bold text-white mb-2">
                Selamat Datang, {{ auth()->user()->name }}!
            </h3>
            <p class="text-blue-100 mb-4">
                @if(auth()->user()->organization)
                    Anda adalah anggota dari <span
                        class="font-semibold text-white">{{ auth()->user()->organization->name }}</span>
                @else
                    Selamat datang di Event Management System
                @endif
            </p>
            <a href="{{ route('user.profile') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                        fill="currentColor" />
                </svg>
                Lihat Profile
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 md:gap-6 2xl:gap-7.5 mb-6">
            <!-- My Events -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Event Tersedia</h4>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->organization ? auth()->user()->organization->events()->where('status', 'approved')->count() : 0 }}
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

            <!-- My Certificates -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Sertifikat Saya</h4>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->certificates()->count() }}
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

            <!-- My Registrations -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Status Daftar Ulang</h4>
                        <span class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->registrations()->where('year', date('Y'))->where('status', 'approved')->count() > 0 ? 'Aktif' : 'Belum' }}
                        </span>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                        <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Events Card -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Event Terbaru</h3>
                    <a href="{{ route('user.events.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Lihat Semua →
                    </a>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Lihat event yang tersedia dan daftar untuk mengikuti event yang menarik.
                </p>
                <div class="mt-4">
                    <a href="{{ route('user.events.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"
                                fill="currentColor" />
                        </svg>
                        Lihat Event
                    </a>
                </div>
            </div>

            <!-- Certificates Card -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sertifikat</h3>
                    <a href="{{ route('user.certificates.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Lihat Semua →
                    </a>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Akses dan download sertifikat yang telah Anda peroleh dari berbagai event.
                </p>
                <div class="mt-4">
                    <a href="{{ route('user.certificates.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12z"
                                fill="currentColor" />
                        </svg>
                        Lihat Sertifikat
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection