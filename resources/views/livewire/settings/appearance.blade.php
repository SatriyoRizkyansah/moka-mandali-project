@layout('components.layouts.app')

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        <div class="space-y-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <label class="relative cursor-pointer">
                    <input type="radio" name="theme" value="light" class="sr-only" x-model="theme">
                    <div class="flex items-center justify-center p-4 border-2 rounded-lg transition-colors"
                         :class="theme === 'light' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-gray-200 dark:border-gray-700'">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Light') }}</span>
                        </div>
                    </div>
                </label>

                <label class="relative cursor-pointer">
                    <input type="radio" name="theme" value="dark" class="sr-only" x-model="theme">
                    <div class="flex items-center justify-center p-4 border-2 rounded-lg transition-colors"
                         :class="theme === 'dark' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-gray-200 dark:border-gray-700'">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Dark') }}</span>
                        </div>
                    </div>
                </label>

                <label class="relative cursor-pointer">
                    <input type="radio" name="theme" value="system" class="sr-only" x-model="theme">
                    <div class="flex items-center justify-center p-4 border-2 rounded-lg transition-colors"
                         :class="theme === 'system' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-gray-200 dark:border-gray-700'">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('System') }}</span>
                        </div>
                    </div>
                </label>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Choose how the interface looks for you. The system setting will automatically switch between light and dark themes based on your device preference.') }}
            </p>
        </div>

        <script>
            // Update theme when radio changes
            document.addEventListener('alpine:init', () => {
                Alpine.data('themeSelector', () => ({
                    theme: localStorage.getItem('theme') || 'system',
                    init() {
                        this.$watch('theme', (value) => {
                            localStorage.setItem('theme', value);
                            this.applyTheme(value);
                        });
                        this.applyTheme(this.theme);
                    },
                    applyTheme(theme) {
                        if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    }
                }))
            });
        </script>
    </x-settings.layout>
</section>
