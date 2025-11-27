@extends('layouts.app')

@section('title', 'Review Event')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Review Event
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium" href="{{ route('super.events.pending') }}">Pending /</a></li>
                    <li class="font-medium text-primary">Review</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 gap-9 lg:grid-cols-2">
            <!-- Event Details -->
            <div class="flex flex-col gap-9">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                        <h3 class="font-medium text-black dark:text-white">
                            Detail Event
                        </h3>
                    </div>
                    <div class="p-6.5">
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white font-bold">Judul</label>
                            <p class="text-black dark:text-white">{{ $event->title }}</p>
                        </div>
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white font-bold">Organisasi</label>
                            <p class="text-black dark:text-white">{{ $event->organization->name }}</p>
                        </div>
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white font-bold">Dibuat Oleh</label>
                            <p class="text-black dark:text-white">{{ $event->creator->name }}</p>
                        </div>
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white font-bold">Waktu</label>
                            <p class="text-black dark:text-white">
                                {{ $event->event_date->format('d F Y') }} <br>
                                {{ $event->event_time->format('H:i') }} WIB
                            </p>
                        </div>
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white font-bold">Lokasi</label>
                            <p class="text-black dark:text-white">{{ $event->location }}</p>
                        </div>
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white font-bold">Deskripsi</label>
                            <div
                                class="text-black dark:text-white whitespace-pre-line border rounded p-3 bg-gray-50 dark:bg-meta-4">
                                {{ $event->description }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approval Actions -->
            <div class="flex flex-col gap-9">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                        <h3 class="font-medium text-black dark:text-white">
                            Aksi Persetujuan
                        </h3>
                    </div>
                    <div class="p-6.5">
                        <p class="mb-6 text-black dark:text-white">
                            Silakan review detail event di samping. Jika sesuai, klik <strong>Approve</strong>. Jika tidak,
                            klik <strong>Reject</strong> dan berikan alasannya.
                        </p>

                        <div class="flex flex-col gap-4">
                            <form action="{{ route('super.events.approve', $event) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex w-full justify-center rounded bg-success p-3 font-medium text-white hover:bg-opacity-90"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui event ini?')">
                                    Approve Event
                                </button>
                            </form>

                            <hr class="border-stroke dark:border-strokedark">

                            <form action="{{ route('super.events.reject', $event) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="mb-2.5 block text-black dark:text-white">
                                        Alasan Penolakan <span class="text-meta-1">*</span>
                                    </label>
                                    <textarea name="rejection_reason" rows="4" placeholder="Masukkan alasan penolakan..."
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        required></textarea>
                                </div>
                                <button type="submit"
                                    class="flex w-full justify-center rounded bg-danger p-3 font-medium text-white hover:bg-opacity-90"
                                    onclick="return confirm('Apakah Anda yakin ingin menolak event ini?')">
                                    Reject Event
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection