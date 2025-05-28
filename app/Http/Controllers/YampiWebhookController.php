<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class YampiWebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $payload = $request->all();
            $event = $request->header('X-Yampi-Event');

            // Verificar a assinatura do webhook
            $signature = $request->header('X-Yampi-Signature');
            if (!$this->verifySignature($signature, $request->getContent())) {
                Log::error('Yampi Webhook: Assinatura inválida');
                return response()->json(['error' => 'Assinatura inválida'], 401);
            }

            // Encontrar a integração da Yampi
            $integration = Integration::where('platform', 'yampi')
                ->where('user_id', auth()->id())
                ->first();

            if (!$integration) {
                Log::error('Yampi Webhook: Integração não encontrada');
                return response()->json(['error' => 'Integração não encontrada'], 404);
            }

            // Processar o evento
            switch ($event) {
                case 'product.created':
                case 'product.updated':
                    $this->handleProductEvent($payload, $integration);
                    break;

                case 'product.deleted':
                    $this->handleProductDeleted($payload, $integration);
                    break;

                case 'order.created':
                case 'order.updated':
                    $this->handleOrderEvent($payload, $integration);
                    break;

                case 'order.status_changed':
                    $this->handleOrderStatusChanged($payload, $integration);
                    break;

                case 'stock.updated':
                    $this->handleStockEvent($payload, $integration);
                    break;

                case 'variant.created':
                case 'variant.updated':
                    $this->handleVariantEvent($payload, $integration);
                    break;

                case 'variant.deleted':
                    $this->handleVariantDeleted($payload, $integration);
                    break;

                default:
                    Log::info('Yampi Webhook: Evento não tratado', ['event' => $event]);
                    break;
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Yampi Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => 'Erro interno'], 500);
        }
    }

    protected function verifySignature($signature, $payload)
    {
        $apiSecret = Crypt::decryptString(Integration::where('platform', 'yampi')
            ->where('user_id', auth()->id())
            ->value('api_secret'));

        $expectedSignature = hash_hmac('sha256', $payload, $apiSecret);
        return hash_equals($expectedSignature, $signature);
    }

    protected function handleProductEvent($payload, $integration)
    {
        $product = Product::updateOrCreate(
            ['external_id' => $payload['id']],
            [
                'name' => $payload['name'],
                'description' => $payload['description'] ?? '',
                'price' => $payload['price']['amount'] ?? 0,
                'stock' => $payload['stock']['quantity'] ?? 0,
                'status' => $payload['status'] === 'active',
                'integration_id' => $integration->id,
                'sku' => $payload['sku'] ?? null,
            ]
        );

        // Atualizar categorias
        if (isset($payload['categories'])) {
            $product->categories()->sync($payload['categories']);
        }

        // Atualizar imagens
        if (isset($payload['images'])) {
            $product->images()->sync($payload['images']);
        }

        Log::info('Yampi Webhook: Produto sincronizado', ['product_id' => $product->id]);
    }

    protected function handleProductDeleted($payload, $integration)
    {
        $product = Product::where('external_id', $payload['id'])
            ->where('integration_id', $integration->id)
            ->first();

        if ($product) {
            $product->delete();
            Log::info('Yampi Webhook: Produto excluído', ['product_id' => $product->id]);
        }
    }

    protected function handleOrderEvent($payload, $integration)
    {
        // Implementar lógica para processar pedidos
        Log::info('Yampi Webhook: Pedido recebido', [
            'order_id' => $payload['id'],
            'status' => $payload['status'],
            'total' => $payload['total'],
        ]);
    }

    protected function handleOrderStatusChanged($payload, $integration)
    {
        // Implementar lógica para atualizar status do pedido
        Log::info('Yampi Webhook: Status do pedido alterado', [
            'order_id' => $payload['id'],
            'old_status' => $payload['old_status'],
            'new_status' => $payload['new_status'],
        ]);
    }

    protected function handleStockEvent($payload, $integration)
    {
        $product = Product::where('external_id', $payload['product_id'])
            ->where('integration_id', $integration->id)
            ->first();

        if ($product) {
            $product->stock = $payload['quantity'];
            $product->save();
            Log::info('Yampi Webhook: Estoque atualizado', [
                'product_id' => $product->id,
                'quantity' => $payload['quantity'],
            ]);
        }
    }

    protected function handleVariantEvent($payload, $integration)
    {
        $product = Product::where('external_id', $payload['product_id'])
            ->where('integration_id', $integration->id)
            ->first();

        if ($product) {
            // Atualizar ou criar variante
            $variant = $product->variants()->updateOrCreate(
                ['external_id' => $payload['id']],
                [
                    'name' => $payload['name'],
                    'sku' => $payload['sku'],
                    'price' => $payload['price']['amount'],
                    'stock' => $payload['stock']['quantity'],
                ]
            );

            Log::info('Yampi Webhook: Variante sincronizada', [
                'product_id' => $product->id,
                'variant_id' => $variant->id,
            ]);
        }
    }

    protected function handleVariantDeleted($payload, $integration)
    {
        $product = Product::where('external_id', $payload['product_id'])
            ->where('integration_id', $integration->id)
            ->first();

        if ($product) {
            $variant = $product->variants()
                ->where('external_id', $payload['id'])
                ->first();

            if ($variant) {
                $variant->delete();
                Log::info('Yampi Webhook: Variante excluída', [
                    'product_id' => $product->id,
                    'variant_id' => $variant->id,
                ]);
            }
        }
    }
} 