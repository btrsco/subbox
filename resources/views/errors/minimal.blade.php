<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>@yield('title') - {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://cdn.serve.ooo">

        @routes
        @vite(['resources/styles/app.scss'])
    </head>

    @php($code = intval(View::getSection('code')))

    <body class="font-sans antialiased flex flex-col md:flex-row w-full h-screen">
        <main class="w-full p-4 md:p-8 flex flex-col gap-24 md:gap-12">
            <header class="flex flex-row items-center justify-between flex-no-wrap w-full">
                <div class="flex justify-center gap-4">
                    @include('errors.logo')

                    <div class="text-xs font-semibold px-2 py-1 rounded-sm bg-muted text-muted-foreground w-auto">
                        @yield('code')
                    </div>
                </div>
                @if($code !== 503)
                    <ul class="list-none text-sm flex flex-row ml-auto">
                        @auth('web')
                            <li>
                                <a
                                    href="{{ route('dashboard.home.index') }}"
                                    class="inline-flex items-center justify-center whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 rounded-md px-3 text-xs text-muted-foreground">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 rounded-md px-3 text-xs text-muted-foreground">
                                        Log out
                                    </button>
                                </form>
                            </li>
                        @else
                            <li>
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex items-center justify-center whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 rounded-md px-3 text-xs text-muted-foreground">
                                    Log in
                                </a>
                            </li>
                            <li>
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-8 rounded-md px-3 text-xs text-muted-foreground">
                                    Register
                                </a>
                            </li>
                        @endauth
                    </ul>
                @else
                    <div></div>
                @endif
            </header>
            <div class="flex flex-1 justify-center items-center">
                <section class="w-full max-w-80 space-y-6">
                    <div class="flex flex-col items-center justify-start flex-no-wrap text-center gap-2">
                        <h1 class="text-2xl md:text-3xl font-semibold tracking-tight">@yield('heading')</h1>
                        <p class="text-muted-foreground">@yield('message')</p>
                    </div>

                    @if($code !== 503)
                        <a
                            href="@yield('button_url', route('home'))"
                            class="mt-4 gap-2 inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground shadow hover:bg-primary/90 h-9 px-4 py-2 w-full">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="size-4">
                                <path d="m12 19-7-7 7-7" />
                                <path d="M19 12H5" />
                            </svg>
                            @yield('button_text', 'Go back home')
                        </a>
                    @endif
                </section>
            </div>
            <footer>
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.
                </p>
            </footer>
        </main>
    </body>
</html>
