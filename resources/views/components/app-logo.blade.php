@php
    $candidates = ['moka.png', 'logo.png', 'logo.jpg', 'moka.jpg'];
    $logoUrl = null;
    foreach ($candidates as $f) {
        if (file_exists(public_path('assets/logo/' . $f))) {
            $logoUrl = asset('assets/logo/' . $f);
            break;
        }
    }
@endphp

<div class="flex items-center space-x-3">
    @if($logoUrl)
        <div class="relative">
            <div class="rounded-2xl p-1 bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg">
                <img src="{{ $logoUrl }}" alt="{{ config('app.name', 'MOKA MANDALI') }} logo" class="w-12 h-12 rounded-xl object-cover block" onerror="this.parentElement.style.display='none'; this.parentElement.nextElementSibling.style.display='flex'" />
            </div>
            <div class="absolute -bottom-2 left-0 right-0 flex justify-center text-xs text-yellow-700 font-semibold opacity-90"> </div>
        </div>
        <div class="hidden">
            <x-app-logo-icon class="size-6 fill-current text-white dark:text-black" />
        </div>
    @else
        <div class="flex items-center justify-center rounded-2xl p-1 bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg">
            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-inner">
                <x-app-logo-icon class="w-8 h-8 fill-current text-yellow-500" />
            </div>
        </div>
    @endif

    <div class="ms-1 grid flex-1 text-start">
        <div class="flex items-center space-x-1">
            <span class="text-sm font-extrabold tracking-tight text-gray-900">{{ config('app.name', 'MOKA MANDALI') }}</span>
        </div>
        <div class="text-xs text-gray-500">Creative Dashboard</div>
    </div>
</div>
