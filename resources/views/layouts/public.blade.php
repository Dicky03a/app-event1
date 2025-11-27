<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-boxdark-2 dark:text-bodydark">
    <!-- ===== Header Start ===== -->
    <header class="sticky top-0 z-999 flex w-full bg-white drop-shadow-1 dark:bg-boxdark dark:drop-shadow-none">
        <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
            <div class="flex items-center gap-2 sm:gap-4">
                <a class="block flex-shrink-0" href="{{ route('home') }}">
                    <h1 class="text-xl font-bold text-black dark:text-white">EventApp</h1>
                </a>
            </div>

            <div class="flex items-center gap-3 2xsm:gap-7">
                <ul class="flex items-center gap-2 2xsm:gap-4">
                    <li><a href="{{ route('home') }}" class="font-medium hover:text-primary">Home</a></li>
                    <li><a href="{{ route('events.index') }}" class="font-medium hover:text-primary">Events</a></li>
                </ul>

                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="text-sm font-medium text-primary hover:underline">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-primary hover:underline">Log in</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </header>
    <!-- ===== Header End ===== -->

    <!-- ===== Main Content Start ===== -->
    <main>
        @yield('content')
    </main>
    <!-- ===== Main Content End ===== -->

    <!-- ===== Footer Start ===== -->
    <footer class="bg-white p-6 text-center dark:bg-boxdark">
        <p>&copy; {{ date('Y') }} EventApp. All rights reserved.</p>
    </footer>
    <!-- ===== Footer End ===== -->
</body>

</html>