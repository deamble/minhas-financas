<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('integrations.edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('integrations.update', $integration) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('integrations.name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $integration->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('integrations.description')" />
                            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $integration->description)" />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        @if($integration->platform === 'yampi')
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('integrations.yampi.settings') }}</h3>
                                
                                <div>
                                    <x-input-label for="api_key" :value="__('integrations.api_key')" />
                                    <x-text-input id="api_key" name="api_key" type="text" class="mt-1 block w-full" :value="old('api_key', $integration->api_key)" required />
                                    <p class="mt-1 text-sm text-gray-500">{{ __('integrations.yampi.api_key_help') }}</p>
                                    <x-input-error class="mt-2" :messages="$errors->get('api_key')" />
                                </div>

                                <div>
                                    <x-input-label for="api_secret" :value="__('integrations.api_secret')" />
                                    <x-text-input id="api_secret" name="api_secret" type="password" class="mt-1 block w-full" :value="old('api_secret', $integration->api_secret)" required />
                                    <p class="mt-1 text-sm text-gray-500">{{ __('integrations.yampi.api_secret_help') }}</p>
                                    <x-input-error class="mt-2" :messages="$errors->get('api_secret')" />
                                </div>

                                <div>
                                    <x-input-label for="webhook_url" :value="__('integrations.yampi.webhook_url')" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <x-text-input id="webhook_url" type="text" class="flex-1 block w-full" :value="route('webhooks.yampi')" readonly />
                                        <button type="button" onclick="copyToClipboard('webhook_url')" class="ml-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                            {{ __('integrations.yampi.copy') }}
                                        </button>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">{{ __('integrations.yampi.webhook_help') }}</p>
                                </div>

                                <div class="space-y-2">
                                    <h4 class="text-sm font-medium text-gray-900">{{ __('integrations.yampi.sync_options') }}</h4>
                                    
                                    <div class="flex items-center">
                                        <input id="sync_products" name="settings[sync_products]" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                            {{ old('settings.sync_products', $integration->settings['sync_products'] ?? true) ? 'checked' : '' }}>
                                        <label for="sync_products" class="ml-2 text-sm text-gray-600">{{ __('integrations.yampi.sync_products') }}</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="sync_orders" name="settings[sync_orders]" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ old('settings.sync_orders', $integration->settings['sync_orders'] ?? true) ? 'checked' : '' }}>
                                        <label for="sync_orders" class="ml-2 text-sm text-gray-600">{{ __('integrations.yampi.sync_orders') }}</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="sync_stock" name="settings[sync_stock]" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            {{ old('settings.sync_stock', $integration->settings['sync_stock'] ?? true) ? 'checked' : '' }}>
                                        <label for="sync_stock" class="ml-2 text-sm text-gray-600">{{ __('integrations.yampi.sync_stock') }}</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('integrations.save') }}</x-primary-button>
                            <a href="{{ route('integrations.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('integrations.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            element.select();
            document.execCommand('copy');
            
            // Feedback visual
            const button = element.nextElementSibling;
            const originalText = button.textContent;
            button.textContent = '{{ __("integrations.yampi.copied") }}';
            setTimeout(() => {
                button.textContent = originalText;
            }, 2000);
        }
    </script>
    @endpush
</x-app-layout> 