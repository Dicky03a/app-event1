@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Saya</h2>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informasi Profile</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                    <p class="text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <p class="text-gray-900 dark:text-white">{{ auth()->user()->email }}</p>
                </div>

                @if(auth()->user()->organization)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Organisasi</label>
                        <p class="text-gray-900 dark:text-white">{{ auth()->user()->organization->name }}</p>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                    <p class="text-gray-900 dark:text-white">{{ ucfirst(auth()->user()->getRoleNames()->first()) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection