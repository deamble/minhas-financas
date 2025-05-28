<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use App\Services\YampiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class IntegrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'create', 'store']);
    }

    public function index()
    {
        $integrations = Integration::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('integrations.index', compact('integrations'));
    }

    public function create(Request $request)
    {
        $platform = $request->query('platform');
        return view('integrations.create', compact('platform'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'platform' => 'required|string|in:nuvemshop,yampi',
            'token' => 'required_if:platform,yampi|string',
            'secret_key' => 'required_if:platform,yampi|string',
            'settings' => 'nullable|array',
            'settings.store_alias' => 'required_if:platform,yampi|string|max:255',
        ]);

        // Validar credenciais específicas da plataforma
        if ($validated['platform'] === 'yampi') {
            try {
                $yampiService = new YampiService(
                    $validated['token'],
                    $validated['secret_key'],
                    $validated['settings']['store_alias']
                );
                if (!$yampiService->testConnection()) {
                    return back()->withErrors(['token' => __('integrations.yampi.invalid_credentials')]);
                }
            } catch (\Exception $e) {
                Log::error('Yampi API Error: ' . $e->getMessage());
                return back()->withErrors(['token' => __('integrations.yampi.connection_error')]);
            }
        }

        $integration = new Integration();
        $integration->name = $validated['name'];
        $integration->description = $validated['description'];
        $integration->platform = $validated['platform'];
        $integration->api_key = Crypt::encryptString($validated['token'] ?? '');
        $integration->api_secret = Crypt::encryptString($validated['secret_key'] ?? '');
        $integration->settings = $validated['settings'] ?? [];
        $integration->status = true;
        $integration->user_id = auth()->id();
        $integration->save();

        return redirect()->route('integrations.index')
            ->with('success', __('integrations.created'));
    }

    public function test(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|in:yampi',
            'token' => 'required|string',
            'secret_key' => 'required|string',
            'settings.store_alias' => 'required|string|max:255',
        ]);

        try {
            $yampiService = new YampiService(
                $request->token,
                $request->secret_key,
                $request->settings['store_alias']
            );
            
            $result = $yampiService->testConnection();

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => __('integrations.yampi.test_success')
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => __('integrations.yampi.invalid_credentials')
            ], 422);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody(), true);
            
            Log::error('Yampi API Test Error: Client Exception', [
                'status' => $response->getStatusCode(),
                'body' => $body,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $body['message'] ?? __('integrations.yampi.invalid_credentials')
            ], $response->getStatusCode());

        } catch (\GuzzleHttp\Exception\ServerException $e) {
            Log::error('Yampi API Test Error: Server Exception', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('integrations.yampi.connection_error')
            ], 500);

        } catch (\Exception $e) {
            Log::error('Yampi API Test Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => __('integrations.yampi.connection_error')
            ], 500);
        }
    }

    public function edit(Integration $integration)
    {
        return view('integrations.edit', compact('integration'));
    }

    public function update(Request $request, Integration $integration)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
            'settings' => 'nullable|array',
        ]);

        // Validar credenciais específicas da plataforma
        if ($integration->platform === 'yampi') {
            try {
                $yampiService = new YampiService($validated['api_key'], $validated['api_secret']);
                if (!$yampiService->testConnection()) {
                    return back()->withErrors(['api_key' => __('integrations.yampi.invalid_credentials')]);
                }
            } catch (\Exception $e) {
                Log::error('Yampi API Error: ' . $e->getMessage());
                return back()->withErrors(['api_key' => __('integrations.yampi.connection_error')]);
            }
        }

        $integration->name = $validated['name'];
        $integration->description = $validated['description'];
        $integration->api_key = Crypt::encryptString($validated['api_key']);
        $integration->api_secret = Crypt::encryptString($validated['api_secret']);
        $integration->settings = $validated['settings'] ?? $integration->settings;
        $integration->save();

        return redirect()->route('integrations.index')
            ->with('success', __('integrations.updated'));
    }

    public function destroy(Integration $integration)
    {
        $integration->delete();

        return redirect()->route('integrations.index')
            ->with('success', __('integrations.deleted'));
    }
} 