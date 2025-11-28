@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Super Admin Dashboard
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5 mb-6">
            <!-- Total Organizations -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Organisasi</h4>
                        <span
                            class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Organization::count() }}</span>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/20">
                        <svg class="fill-blue-600 dark:fill-blue-400" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</h4>
                        <span
                            class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</span>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                        <svg class="fill-green-600 dark:fill-green-400" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Events -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Event</h4>
                        <span
                            class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Event::count() }}</span>
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

            <!-- Pending Approvals -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Approval</h4>
                        <span
                            class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Event::where('status', 'pending')->count() }}</span>
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
                Anda login sebagai <span class="font-semibold text-blue-600 dark:text-blue-400">Super Administrator</span>.
                Anda memiliki akses penuh ke semua fitur sistem.
            </p>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('super.organizations.index') }}"
                    class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/20">
                        <svg class="fill-blue-600 dark:fill-blue-400" width="20" height="20" viewBox="0 0 24 24">
                            <path d="M12 7V3H2v18h20V7H12z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Kelola Organisasi</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Manage all organizations</p>
                    </div>
                </a>

                <a href="{{ route('super.events.all') }}"
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">View and manage all events</p>
                    </div>
                </a>

                <a href="#"
                    class="flex items-center gap-3 p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                        <svg class="fill-green-600 dark:fill-green-400" width="20" height="20" viewBox="0 0 24 24">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Kelola Users</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Manage users and roles</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection