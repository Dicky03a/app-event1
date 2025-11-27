@extends('layouts.app')

@section('title', 'Sertifikat')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Kelola Sertifikat</h2>
        </div>

        <div
            class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm dark:border-gray-800 dark:bg-gray-800 text-center">
            <div
                class="mx-auto w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mb-4">
                <svg class="fill-blue-600 dark:fill-blue-400" width="32" height="32" viewBox="0 0 24 24">
                    <path
                        d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12zM10 9h8v2h-8zm0 3h4v2h-4zm0-6h8v2h-8z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Halaman Sertifikat</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Fitur manajemen sertifikat akan tersedia di sini. Anda dapat menerbitkan sertifikat, melihat daftar
                sertifikat, dan mendownload sertifikat.
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-500">
                Placeholder - Implementasi CRUD dan download sertifikat akan ditambahkan sesuai kebutuhan
            </p>
        </div>
    </div>
@endsection