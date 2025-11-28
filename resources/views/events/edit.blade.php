@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Event
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium" href="{{ route('admin.events.index') }}">Event /</a></li>
                    <li class="font-medium text-primary">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Form Edit Event
                </h3>
            </div>
            <form action="{{ route('admin.events.update', $event) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6.5">
                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Judul Event <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}"
                            placeholder="Masukkan judul event"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                            required />
                        @error('title')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Deskripsi <span class="text-meta-1">*</span>
                        </label>
                        <textarea name="description" rows="6" placeholder="Masukkan deskripsi event"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                            required>{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Tanggal <span class="text-meta-1">*</span>
                            </label>
                            <input type="date" name="event_date"
                                value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                required />
                            @error('event_date')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Waktu <span class="text-meta-1">*</span>
                            </label>
                            <input type="time" name="event_time"
                                value="{{ old('event_time', $event->event_time->format('H:i')) }}"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                required />
                            @error('event_time')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">
                            Lokasi <span class="text-meta-1">*</span>
                        </label>
                        <input type="text" name="location" value="{{ old('location', $event->location) }}"
                            placeholder="Masukkan lokasi event"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                            required />
                        @error('location')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4.5 flex flex-col gap-4">
                        <!-- Is Free Checkbox -->
                        <label class="flex items-center cursor-pointer">
                            <input type="hidden" name="is_free" value="{{$event->is_free ? '1' : '0'}}" id="is_free_hidden">
                            <input type="checkbox" id="is_free_checkbox" class="sr-only" {{$event->is_free ? 'checked' : ''}}>
                            <div class="relative w-10 h-6 bg-gray-300 rounded-full shadow-inner">
                                <div class="absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transform transition-transform duration-300 ease-in-out"></div>
                            </div>
                            <span class="ml-3 text-black dark:text-white">Event Gratis</span>
                        </label>

                        <!-- Price Input -->
                        <div id="price_section" class="w-full" style="{{$event->is_free ? 'display: none;' : 'display: block;'}}">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Harga <span class="text-meta-1">*</span>
                            </label>
                            <input type="number" name="price" value="{{ old('price', $event->price) }}" placeholder="Masukkan harga event"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            @error('price')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit"
                        class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const isFreeCheckbox = document.getElementById('is_free_checkbox');
                    const isFreeHidden = document.getElementById('is_free_hidden');
                    const priceSection = document.getElementById('price_section');

                    // Set initial state based on event data
                    const isFreeValue = {{$event->is_free ? 'true' : 'false'}};
                    if (isFreeValue) {
                        isFreeCheckbox.checked = true;
                        isFreeHidden.value = '1';
                        priceSection.style.display = 'none';
                    } else {
                        isFreeCheckbox.checked = false;
                        isFreeHidden.value = '0';
                        priceSection.style.display = 'block';
                    }

                    // Update hidden input and price section visibility when checkbox changes
                    isFreeCheckbox.addEventListener('change', function() {
                        if (this.checked) {
                            isFreeHidden.value = '1';
                            priceSection.style.display = 'none';
                        } else {
                            isFreeHidden.value = '0';
                            priceSection.style.display = 'block';
                        }
                    });
                });
            </script>
        </div>
    </div>
@endsection