@extends('layouts.app')

@section('title', 'Detail Organisasi')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detail Organisasi
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium" href="{{ route('super.organizations.index') }}">Organisasi /</a></li>
                    <li class="font-medium text-primary">Detail</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 gap-9 xl:grid-cols-3">
            <!-- Organization Profile -->
            <div
                class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-2">
                <div class="relative z-20 h-35 md:h-65">
                    <div class="absolute bottom-0 right-0 left-0 top-0 bg-primary/20"></div>
                    <div class="absolute bottom-1 right-1 z-10 xsm:bottom-4 xsm:right-4">
                        @can('organization.update')
                            <a href="{{ route(auth()->user()->isSuperAdmin() ? 'super.organizations.edit' : 'admin.organizations.edit', $organization) }}"
                                class="flex items-center justify-center gap-2 rounded bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
                                <span>
                                    <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.225 2.20001L13.8 3.77501C14.125 4.10001 14.125 4.62501 13.8 4.95001L13.05 5.70001L10.3 2.95001L11.05 2.20001C11.375 1.87501 11.9 1.87501 12.225 2.20001ZM9.55 3.70001L12.3 6.45001L4.55 14.2L1.8 14.2L1.8 11.45L9.55 3.70001Z"
                                            fill="" />
                                    </svg>
                                </span>
                                <span>Edit</span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="px-4 pb-6 text-center lg:pb-8 xl:pb-11.5">
                    <div
                        class="relative mx-auto -mt-22 h-30 w-full max-w-30 rounded-full bg-white/20 p-1 backdrop-blur sm:h-44 sm:max-w-44 sm:p-3">
                        <div class="relative drop-shadow-2">
                            @if ($organization->logo)
                                <img src="{{ Storage::url($organization->logo) }}" alt="Logo"
                                    class="h-full w-full object-cover rounded-full" />
                            @else
                                <div
                                    class="flex h-28 w-28 sm:h-38 sm:w-38 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 mx-auto">
                                    <span class="text-xl font-bold">{{ substr($organization->name, 0, 2) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="mb-1.5 text-2xl font-semibold text-black dark:text-white">
                            {{ $organization->name }}
                        </h3>
                        <p class="font-medium">{{ $organization->slug }}</p>
                        <div
                            class="mx-auto mt-4.5 mb-5.5 grid max-w-94 grid-cols-3 rounded-md border border-stroke py-2.5 shadow-1 dark:border-strokedark dark:bg-[#37404F]">
                            <div
                                class="flex flex-col items-center justify-center gap-1 border-r border-stroke px-4 dark:border-strokedark xsm:flex-row">
                                <span
                                    class="font-semibold text-black dark:text-white">{{ $organization->users->count() }}</span>
                                <span class="text-sm">Anggota</span>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center gap-1 border-r border-stroke px-4 dark:border-strokedark xsm:flex-row">
                                <span
                                    class="font-semibold text-black dark:text-white">{{ $organization->events->count() }}</span>
                                <span class="text-sm">Event</span>
                            </div>
                            <div class="flex flex-col items-center justify-center gap-1 px-4 xsm:flex-row">
                                <span
                                    class="font-semibold text-black dark:text-white">{{ $organization->registrations->count() }}</span>
                                <span class="text-sm">Peserta</span>
                            </div>
                        </div>

                        <div class="mx-auto max-w-180">
                            <h4 class="font-semibold text-black dark:text-white mb-2">Tentang Organisasi</h4>
                            <p class="mt-4.5 text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ $organization->description ?? 'Belum ada deskripsi.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Organization Details -->
            <div
                class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-1">
                <div class="border-b border-stroke px-7.5 py-4 dark:border-strokedark">
                    <h4 class="text-xl font-semibold text-black dark:text-white">
                        Informasi Kontak
                    </h4>
                </div>
                <div class="p-7.5">
                    <div class="mb-7 flex items-center gap-4">
                        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                            <svg class="fill-primary" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.5 14.5833V16.25C17.5 16.9404 16.9404 17.5 16.25 17.5H3.75C3.05964 17.5 2.5 16.9404 2.5 16.25V14.5833C2.5 13.893 3.05964 13.3333 3.75 13.3333H16.25C16.9404 13.3333 17.5 13.893 17.5 14.5833ZM17.5 5.41667V3.75C17.5 3.05964 16.9404 2.5 16.25 2.5H3.75C3.05964 2.5 2.5 3.05964 2.5 3.75V5.41667C2.5 6.10703 3.05964 6.66667 3.75 6.66667H16.25C16.9404 6.66667 17.5 6.10703 17.5 5.41667ZM16.25 8.33333H3.75C3.05964 8.33333 2.5 8.89297 2.5 9.58333V11.25C2.5 11.9404 3.05964 12.5 3.75 12.5H16.25C16.9404 12.5 17.5 11.9404 17.5 11.25V9.58333C17.5 8.89297 16.9404 8.33333 16.25 8.33333Z"
                                    fill="" />
                            </svg>
                        </div>
                        <div>
                            <span class="mb-1.5 text-black dark:text-white font-medium">Email</span>
                            <span class="block text-sm">{{ $organization->email ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="mb-7 flex items-center gap-4">
                        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                            <svg class="fill-primary" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.4062 13.4375L14.0938 11.125C13.7812 10.8125 13.2812 10.8125 12.9688 11.125L11.5312 12.5625C11.25 12.8438 10.7812 12.8438 10.5 12.5625C9.375 11.4375 8.5625 10.625 7.4375 9.5C7.15625 9.21875 7.15625 8.75 7.4375 8.46875L8.875 7.03125C9.1875 6.71875 9.1875 6.21875 8.875 5.90625L6.5625 3.59375C6.25 3.28125 5.75 3.28125 5.4375 3.59375L3.9375 5.09375C3.28125 5.75 2.8125 7.15625 4.09375 9.625C5.5625 12.4688 7.53125 14.4375 10.375 15.9062C12.8438 17.1875 14.25 16.7188 14.9062 16.0625L16.4062 14.5625C16.7188 14.25 16.7188 13.75 16.4062 13.4375Z"
                                    fill="" />
                            </svg>
                        </div>
                        <div>
                            <span class="mb-1.5 text-black dark:text-white font-medium">Telepon</span>
                            <span class="block text-sm">{{ $organization->phone ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                            <svg class="fill-primary" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 1.66667C6.31819 1.66667 3.33334 4.65152 3.33334 8.33333C3.33334 12.0152 6.31819 15 10 15C13.6819 15 16.6667 12.0152 16.6667 8.33333C16.6667 4.65152 13.6819 1.66667 10 1.66667ZM10 13.3333C7.23858 13.3333 5.00001 11.0948 5.00001 8.33333C5.00001 5.57191 7.23858 3.33333 10 3.33333C12.7614 3.33333 15 5.57191 15 8.33333C15 11.0948 12.7614 13.3333 10 13.3333Z"
                                    fill="" />
                                <path
                                    d="M10 5.83333C9.53977 5.83333 9.16667 6.20643 9.16667 6.66667V9.16667C9.16667 9.62691 9.53977 10 10 10C10.4602 10 10.8333 9.62691 10.8333 9.16667V6.66667C10.8333 6.20643 10.4602 5.83333 10 5.83333Z"
                                    fill="" />
                                <path
                                    d="M10 10.8333C9.53977 10.8333 9.16667 11.2064 9.16667 11.6667C9.16667 12.1269 9.53977 12.5 10 12.5C10.4602 12.5 10.8333 12.1269 10.8333 11.6667C10.8333 11.2064 10.4602 10.8333 10 10.8333Z"
                                    fill="" />
                            </svg>
                        </div>
                        <div>
                            <span class="mb-1.5 text-black dark:text-white font-medium">Alamat</span>
                            <span class="block text-sm">{{ $organization->address ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection