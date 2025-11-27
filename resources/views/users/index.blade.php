@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Daftar User
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li class="font-medium text-primary">User</li>
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
            <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            @if(auth()->user()->hasRole('super-admin'))
            <form action="{{ route('super.users.index') }}" method="GET" class="w-full sm:w-1/2">
                <div class="relative z-20 bg-transparent dark:bg-form-input">
                    <select name="organization_id" onchange="this.form.submit()"
                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent px-5 py-3 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                        <option value="">Semua Organisasi</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ request('organization_id') == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                                fill="" />
                        </svg>
                    </span>
                </div>
            </form>
            @else
            <div></div>
            @endif

            <a href="{{ route(auth()->user()->hasRole('super-admin') ? 'super.users.create' : 'admin.users.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-primary px-10 py-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-8 xl:px-10">
                <span>
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.16666V15.8333M4.16666 10H15.8333" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span class="ml-2">Tambah User</span>
            </a>
        </div>

            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                                Nama
                            </th>
                            <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                                Email
                            </th>
                            <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                                Role
                            </th>
                            <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                                Organisasi
                            </th>
                            <th class="px-4 py-4 font-medium text-black dark:text-white">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 class="font-medium text-black dark:text-white">{{ $user->name }}</h5>
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <p class="text-black dark:text-white">{{ $user->email }}</p>
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    @foreach($user->roles as $role)
                                        <span
                                            class="inline-flex rounded-full bg-primary bg-opacity-10 px-3 py-1 text-sm font-medium text-primary">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <p class="text-black dark:text-white">{{ $user->organization->name ?? '-' }}</p>
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <div class="flex items-center space-x-3.5">
                                        <a href="{{ route(auth()->user()->hasRole('super-admin') ? 'super.users.edit' : 'admin.users.edit', $user) }}"
                                            class="hover:text-primary">
                                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.7531 2.47501L15.525 4.24689C15.8906 4.61251 15.8906 5.20314 15.525 5.56876L14.6812 6.41251L11.5875 3.31876L12.4312 2.47501C12.7969 2.10939 13.3875 2.10939 13.7531 2.47501ZM10.7437 4.16251L13.8375 7.25626L5.11875 15.975L2.025 15.975L2.025 12.8813L10.7437 4.16251Z"
                                                    fill="" />
                                            </svg>
                                        </a>
                                        <form
                                            action="{{ route(auth()->user()->hasRole('super-admin') ? 'super.users.destroy' : 'admin.users.destroy', $user) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-5 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada user yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection