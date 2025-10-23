{{-- Wrapper layout so Livewire page components can reference "layouts.customer".
     This reuses the existing Blade component at resources/views/components/layouts/customer.blade.php
     to avoid duplicating markup. --}}
<x-layouts.customer>
    {{ $slot }}
</x-layouts.customer>
