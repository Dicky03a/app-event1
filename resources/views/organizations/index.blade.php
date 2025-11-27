@extends('layouts.app')

@section('title', 'Daftar Organisasi')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Daftar Organisasi
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                <li class="font-medium text-primary">Organisasi</li>
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
        <div class="mb-4 flex justify-end">
            @can('organization.create')
            <a href="{{ route('super.organizations.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-primary px-10 py-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                <span>
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.16666V15.8333M4.16666 10H15.8333" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span class="ml-2 bg-blue-500 px-5 py-3 rounded-full">Tambah Organisasi</span>
            </a>
            @endcan
        </div>

        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                            Nama Organisasi
                        </th>
                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Slug
                        </th>
                        <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                            Dibuat Oleh
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($organizations as $organization)
                    <tr>
                        <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                            <div class="flex items-center gap-3 sm:flex-row sm:items-center">
                                @if ($organization->logo)
                                <div class="h-12.5 w-15 rounded-md overflow-hidden">
                                    <img src="{{ Storage::url($organization->logo) }}" alt="{{ $organization->name }} Logo"
                                        class="h-full w-full object-contain rounded-md" />
                                </div>
                                @else
                                <div
                                    class="flex h-12.5 w-15 items-center justify-center rounded-md bg-gray-100 dark:bg-gray-700 text-gray-500">
                                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                    </svg>
                                </div>
                                @endif
                                <p class="text-sm font-medium text-black dark:text-white">
                                    {{ $organization->name }}
                                </p>
                            </div>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <p class="text-black dark:text-white">
                                {{ $organization->slug }}
                            </p>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <p
                                class="inline-flex rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium {{ $organization->status === 'active' ? 'bg-success text-success' : 'bg-danger text-danger' }}">
                                {{ ucfirst($organization->status) }}
                            </p>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <p class="text-black dark:text-white">
                                {{ $organization->creator->name ?? '-' }}
                            </p>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <div class="flex items-center space-x-3.5">
                                @can('organization.view')
                                <a href="{{ route(auth()->user()->isSuperAdmin() ? 'super.organizations.show' : 'admin.organizations.show', $organization) }}"
                                    class="hover:text-primary">
                                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.99981 14.8219C5.84981 14.8219 2.94981 12.9094 1.64981 9.98438C1.59356 9.84375 1.59356 9.675 1.64981 9.53437C2.94981 6.60938 5.84981 4.69688 8.99981 4.69688C12.1498 4.69688 15.0498 6.60938 16.3498 9.53437C16.4061 9.675 16.4061 9.84375 16.3498 9.98438C15.0498 12.9094 12.1498 14.8219 8.99981 14.8219ZM8.99981 6.38438C7.25606 6.38438 5.84981 7.79063 5.84981 9.53438C5.84981 11.2781 7.25606 12.6844 8.99981 12.6844C10.7436 12.6844 12.1498 11.2781 12.1498 9.53438C12.1498 7.79063 10.7436 6.38438 8.99981 6.38438Z"
                                            fill="" />
                                    </svg>
                                </a>
                                @endcan
                                @can('organization.update')
                                <a href="{{ route(auth()->user()->isSuperAdmin() ? 'super.organizations.edit' : 'admin.organizations.edit', $organization) }}"
                                    class="hover:text-primary">
                                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13.7531 2.47501L15.525 4.24689C15.8906 4.61251 15.8906 5.20314 15.525 5.56876L14.6812 6.41251L11.5875 3.31876L12.4312 2.47501C12.7969 2.10939 13.3875 2.10939 13.7531 2.47501ZM10.7437 4.16251L13.8375 7.25626L5.11875 15.975L2.025 15.975L2.025 12.8813L10.7437 4.16251Z"
                                            fill="" />
                                    </svg>
                                </a>
                                @endcan
                                @can('organization.delete')
                                <form action="{{ route('super.organizations.destroy', $organization) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus organisasi ini?');">
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
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                            Belum ada organisasi yang dibuat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection