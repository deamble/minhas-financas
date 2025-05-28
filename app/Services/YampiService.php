<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class YampiService
{
    protected $token;
    protected $secretKey;
    protected $storeAlias;
    protected $baseUrl;
    protected $client;

    public function __construct(string $token, string $secretKey, string $storeAlias = null)
    {
        $this->token = $token;
        $this->secretKey = $secretKey;
        $this->storeAlias = $storeAlias;
        $this->baseUrl = 'https://api.yampi.com.br/v1';

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => "Bearer {$this->token}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'verify' => true,
            'timeout' => 30,
            'http_errors' => false // Não lança exceções para erros HTTP
        ]);
    }

    protected function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function testConnection()
    {
        try {
            $response = $this->client->get("stores/{$this->storeAlias}/products", [
                'query' => [
                    'page' => 1,
                    'per_page' => 1
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody(), true);

            if ($statusCode === 200) {
                return true;
            }

            Log::error('Yampi API Test Error: Invalid response', [
                'status' => $statusCode,
                'body' => $body
            ]);
            return false;

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody(), true);
            
            Log::error('Yampi API Test Error: Client Exception', [
                'status' => $response->getStatusCode(),
                'body' => $body,
                'message' => $e->getMessage()
            ]);
            return false;

        } catch (\GuzzleHttp\Exception\ServerException $e) {
            Log::error('Yampi API Test Error: Server Exception', [
                'message' => $e->getMessage()
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('Yampi API Test Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getStore()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/store');

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getProducts($page = 1, $perPage = 50)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/catalog/products', [
                    'page' => $page,
                    'per_page' => $perPage,
                    'include' => 'variants,images,categories',
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getProduct($productId)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/catalog/products/' . $productId, [
                    'include' => 'variants,images,categories',
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function syncProduct($product)
    {
        try {
            $data = [
                'name' => $product->name,
                'description' => $product->description,
                'status' => $product->status ? 'active' : 'inactive',
                'sku' => $product->sku,
                'price' => [
                    'amount' => $product->price,
                    'currency' => 'BRL',
                ],
                'stock' => [
                    'quantity' => $product->stock,
                    'unlimited' => false,
                ],
                'categories' => $product->categories ?? [],
                'images' => $product->images ?? [],
                'variants' => $product->variants ?? [],
            ];

            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl . '/catalog/products', $data);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateProduct($productId, $product)
    {
        try {
            $data = [
                'name' => $product->name,
                'description' => $product->description,
                'status' => $product->status ? 'active' : 'inactive',
                'sku' => $product->sku,
                'price' => [
                    'amount' => $product->price,
                    'currency' => 'BRL',
                ],
                'stock' => [
                    'quantity' => $product->stock,
                    'unlimited' => false,
                ],
            ];

            $response = Http::withHeaders($this->getHeaders())
                ->put($this->baseUrl . '/catalog/products/' . $productId, $data);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getOrders($page = 1, $perPage = 50)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/orders', [
                    'page' => $page,
                    'per_page' => $perPage,
                    'include' => 'items,customer,shipping,payment',
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getOrder($orderId)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/orders/' . $orderId, [
                    'include' => 'items,customer,shipping,payment',
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateOrderStatus($orderId, $status)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->put($this->baseUrl . '/orders/' . $orderId . '/status', [
                    'status' => $status,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCategories($page = 1, $perPage = 50)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/catalog/categories', [
                    'page' => $page,
                    'per_page' => $perPage,
                ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createCategory($name, $parentId = null)
    {
        try {
            $data = [
                'name' => $name,
                'parent_id' => $parentId,
            ];

            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl . '/catalog/categories', $data);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function uploadImage($productId, $imageUrl)
    {
        try {
            $data = [
                'url' => $imageUrl,
            ];

            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl . '/catalog/products/' . $productId . '/images', $data);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createVariant($productId, $variantData)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl . '/catalog/products/' . $productId . '/variants', $variantData);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Yampi API Error: ' . $e->getMessage());
            throw $e;
        }
    }
} 