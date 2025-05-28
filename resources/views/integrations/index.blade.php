@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">{{ __('integrations.title') }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Shopify Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/integrations/shopify.png') }}" alt="Shopify" class="w-12 h-12 mr-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ __('integrations.platforms.shopify') }}</h3>
                    </div>
                    <p class="text-gray-600 mb-4">{{ __('integrations.descriptions.shopify') }}</p>
                    @if($integrations->where('platform', 'shopify')->first())
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ __('integrations.installed') }}
                            </span>
                            <a href="{{ route('integrations.edit', $integrations->where('platform', 'shopify')->first()) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ __('integrations.configure') }}
                            </a>
                        </div>
                    @else
                        <a href="{{ route('integrations.create', ['platform' => 'shopify']) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('integrations.install') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- WooCommerce Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/integrations/woocommerce.png') }}" alt="WooCommerce" class="w-12 h-12 mr-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ __('integrations.platforms.woocommerce') }}</h3>
                    </div>
                    <p class="text-gray-600 mb-4">{{ __('integrations.descriptions.woocommerce') }}</p>
                    @if($integrations->where('platform', 'woocommerce')->first())
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ __('integrations.installed') }}
                            </span>
                            <a href="{{ route('integrations.edit', $integrations->where('platform', 'woocommerce')->first()) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ __('integrations.configure') }}
                            </a>
                        </div>
                    @else
                        <a href="{{ route('integrations.create', ['platform' => 'woocommerce']) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('integrations.install') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Magento Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/integrations/magento.png') }}" alt="Magento" class="w-12 h-12 mr-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ __('integrations.platforms.magento') }}</h3>
                    </div>
                    <p class="text-gray-600 mb-4">{{ __('integrations.descriptions.magento') }}</p>
                    @if($integrations->where('platform', 'magento')->first())
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ __('integrations.installed') }}
                            </span>
                            <a href="{{ route('integrations.edit', $integrations->where('platform', 'magento')->first()) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ __('integrations.configure') }}
                            </a>
                        </div>
                    @else
                        <a href="{{ route('integrations.create', ['platform' => 'magento']) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('integrations.install') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- PrestaShop Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/integrations/prestashop.png') }}" alt="PrestaShop" class="w-12 h-12 mr-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ __('integrations.platforms.prestashop') }}</h3>
                    </div>
                    <p class="text-gray-600 mb-4">{{ __('integrations.descriptions.prestashop') }}</p>
                    @if($integrations->where('platform', 'prestashop')->first())
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ __('integrations.installed') }}
                            </span>
                            <a href="{{ route('integrations.edit', $integrations->where('platform', 'prestashop')->first()) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ __('integrations.configure') }}
                            </a>
                        </div>
                    @else
                        <a href="{{ route('integrations.create', ['platform' => 'prestashop']) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('integrations.install') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Nuvemshop Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/integrations/nuvemshop.png') }}" alt="Nuvemshop" class="w-12 h-12 mr-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ __('integrations.platforms.nuvemshop') }}</h3>
                    </div>
                    <p class="text-gray-600 mb-4">{{ __('integrations.descriptions.nuvemshop') }}</p>
                    @if($integrations->where('platform', 'nuvemshop')->first())
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ __('integrations.installed') }}
                            </span>
                            <a href="{{ route('integrations.edit', $integrations->where('platform', 'nuvemshop')->first()) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ __('integrations.configure') }}
                            </a>
                        </div>
                    @else
                        <a href="{{ route('integrations.create', ['platform' => 'nuvemshop']) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('integrations.install') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Yampi Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/integrations/yampi.png') }}" alt="Yampi" class="w-12 h-12 mr-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ __('integrations.platforms.yampi') }}</h3>
                    </div>
                    <p class="text-gray-600 mb-4">{{ __('integrations.descriptions.yampi') }}</p>
                    @if($integrations->where('platform', 'yampi')->first())
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ __('integrations.installed') }}
                            </span>
                            <a href="{{ route('integrations.edit', $integrations->where('platform', 'yampi')->first()) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ __('integrations.configure') }}
                            </a>
                        </div>
                    @else
                        <a href="{{ route('integrations.create', ['platform' => 'yampi']) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('integrations.install') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 