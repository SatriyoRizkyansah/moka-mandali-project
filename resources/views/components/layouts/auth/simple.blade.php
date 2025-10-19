<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gradient-to-br from-yellow-50 to-orange-50 antialiased">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        
        <div class="relative flex min-h-screen flex-col items-center justify-center gap-6 p-6 md:p-10">
            <!-- Auth Card Container -->
            <div class="w-full max-w-md">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-3 font-medium group" wire:navigate>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl blur-lg opacity-30 group-hover:opacity-50 transition-opacity"></div>
                            <span class="relative flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-yellow-400 to-orange-500 shadow-xl">
                                <x-app-logo-icon class="size-8 fill-current text-white" />
                            </span>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
                            {{ config('app.name', 'Laravel') }}
                        </span>
                    </a>
                </div>

                <!-- Auth Form Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl border border-yellow-200/50 p-8">
                    <div class="flex flex-col gap-6">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
        @fluxScripts
        @livewireScripts
    </body>
</html>
