@extends('layouts.app')

@section('title', 'Daftar Ulang')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Ulang</h2>
        </div>

        <div
            class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm dark:border-gray-800 dark:bg-gray-800 text-center">
            <div
                class="mx-auto w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mb-4">
                <svg class="fill-green-600 dark:fill-green-400" width="32" height="32" viewBox="0 0 24 24">
                    <path
                        d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Halaman Daftar Ulang</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Fitur daftar ulang akan tersedia di sini. Anggota dapat melakukan daftar ulang tahunan dan admin dapat
                mengelola persetujuan.
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-500">
                Placeholder - Implementasi CRUD dan approval workflow akan ditambahkan sesuai kebutuhan
            </p>
        </div>
    </div>
@endsection