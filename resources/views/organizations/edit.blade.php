@extends('layouts.app')

@section('title', 'Edit Organisasi')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Organisasi
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium" href="{{ route('super.organizations.index') }}">Organisasi /</a></li>
                    <li class="font-medium text-primary">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
            <div class="flex flex-col gap-9 sm:col-span-2">
                <!-- Contact Form -->
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                        <h3 class="font-medium text-black dark:text-white">
                            Formulir Edit Organisasi
                        </h3>
                    </div>
                    <form
                        action="{{ route(auth()->user()->isSuperAdmin() ? 'super.organizations.update' : 'admin.organizations.update', $organization) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="p-6.5">
                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Nama Organisasi <span class="text-meta-1">*</span>
                                    </label>
                                    <input type="text" name="name" placeholder="Masukkan nama organisasi"
                                        value="{{ old('name', $organization->name) }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        required />
                                    @error('name')
                                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Email Organisasi
                                    </label>
                                    <input type="email" name="email" placeholder="email@organisasi.com"
                                        value="{{ old('email', $organization->email) }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                    @error('email')
                                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Nomor Telepon
                                    </label>
                                    <input type="text" name="phone" placeholder="08123456789"
                                        value="{{ old('phone', $organization->phone) }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                    @error('phone')
                                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-full xl:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Status <span class="text-meta-1">*</span>
                                    </label>
                                    <div class="relative z-20 bg-transparent dark:bg-form-input">
                                        <select name="status"
                                            class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent px-5 py-3 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="active" {{ old('status', $organization->status) == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive" {{ old('status', $organization->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
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
                                    @error('status')
                                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Alamat
                                </label>
                                <textarea rows="3" name="address" placeholder="Alamat lengkap organisasi"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('address', $organization->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Deskripsi
                                </label>
                                <textarea rows="4" name="description" placeholder="Deskripsi singkat tentang organisasi"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('description', $organization->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Logo Organisasi
                                </label>
                                @if ($organization->logo)
                                    <div class="mb-4">
                                        <img src="{{ Storage::url($organization->logo) }}" alt="Current Logo"
                                            class="h-20 w-auto rounded-md border border-stroke dark:border-strokedark p-1">
                                        <p class="text-xs text-gray-500 mt-1">Logo saat ini</p>
                                    </div>
                                @endif
                                <input type="file" name="logo" accept="image/*"
                                    class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:px-5 file:py-3 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary" />
                                <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah logo.</p>
                                @error('logo')
                                    <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <button
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection