@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">{{ __('integrations.create') }}</h2>

            <form action="{{ route('integrations.store') }}" method="POST" id="integrationForm">
                @csrf
                <input type="hidden" name="platform" value="{{ $platform }}">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('integrations.name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">{{ __('integrations.description') }}</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="token" class="block text-sm font-medium text-gray-700">{{ __('integrations.yampi.token') }}</label>
                    <input type="text" name="token" id="token" value="{{ old('token') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">{{ __('integrations.yampi.token_help') }}</p>
                    @error('token')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="secret_key" class="block text-sm font-medium text-gray-700">{{ __('integrations.yampi.secret_key') }}</label>
                    <input type="password" name="secret_key" id="secret_key" value="{{ old('secret_key') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">{{ __('integrations.yampi.secret_key_help') }}</p>
                    @error('secret_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($platform === 'yampi')
                <div class="mb-4">
                    <label for="store_alias" class="block text-sm font-medium text-gray-700">{{ __('integrations.yampi.store_alias') }}</label>
                    <input type="text" name="settings[store_alias]" id="store_alias" value="{{ old('settings.store_alias') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">{{ __('integrations.yampi.store_alias_help') }}</p>
                    @error('settings.store_alias')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="webhook_url" class="block text-sm font-medium text-gray-700">{{ __('integrations.webhook_url') }}</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" id="webhook_url" value="{{ route('webhooks.yampi') }}" readonly
                            class="block w-full rounded-l-md border-gray-300 bg-gray-50">
                        <button type="button" onclick="copyWebhookUrl()"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-r-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            {{ __('integrations.copy') }}
                        </button>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">{{ __('integrations.webhook_help') }}</p>
                </div>

                <div class="mb-4">
                    <button type="button" onclick="testConnection()" id="testButton"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('integrations.test_connection') }}
                    </button>
                    <div id="testResult" class="mt-2 hidden"></div>
                </div>
                @endif

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('integrations.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('common.cancel') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('common.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($platform === 'yampi')
<script>
function copyWebhookUrl() {
    const webhookUrl = document.getElementById('webhook_url');
    webhookUrl.select();
    document.execCommand('copy');
    
    // Feedback visual
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = '{{ __("common.copied") }}';
    setTimeout(() => {
        button.textContent = originalText;
    }, 2000);
}

function testConnection() {
    const button = document.getElementById('testButton');
    const resultDiv = document.getElementById('testResult');
    const token = document.getElementById('token').value;
    const secretKey = document.getElementById('secret_key').value;
    const storeAlias = document.getElementById('store_alias').value;

    if (!token || !secretKey || !storeAlias) {
        showTestResult('error', '{{ __("integrations.fill_credentials") }}');
        return;
    }

    // Desabilita o botão e mostra loading
    button.disabled = true;
    button.innerHTML = '{{ __("common.testing") }}...';

    fetch('{{ route("integrations.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            platform: 'yampi',
            token: token,
            secret_key: secretKey,
            settings: {
                store_alias: storeAlias
            }
        })
    })
    .then(response => response.json())
    .then(data => {
        showTestResult(data.success ? 'success' : 'error', data.message);
    })
    .catch(error => {
        showTestResult('error', '{{ __("common.error") }}');
    })
    .finally(() => {
        // Reabilita o botão
        button.disabled = false;
        button.innerHTML = '{{ __("integrations.test_connection") }}';
    });
}

function showTestResult(type, message) {
    const resultDiv = document.getElementById('testResult');
    resultDiv.className = `mt-2 p-2 rounded ${type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`;
    resultDiv.textContent = message;
    resultDiv.classList.remove('hidden');
}
</script>
@endif
@endsection 