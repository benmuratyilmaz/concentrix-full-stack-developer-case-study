<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductController extends Controller
{
    public function getAllProduct(Request $request, ProductServices $service): AnonymousResourceCollection
    {
        $isActive = $request->boolean("is_active", true);
        $onSale = $request->boolean("on_sale", true);
        $limit = $request->integer("limit", 10);

        $products = $service->list($isActive, $onSale, $limit);

        return ProductResource::collection($products);
    }

    public function getDetailProduct($id, ProductServices $service): JsonResponse
    {
        $product = $service->detail((int)$id);

        return response()->json([
            'data' => $product,
        ]);
    }

    public function updateProduct(ProductRequest $request, $id, ProductServices $service): JsonResponse
    {
        try {
            $updated = $service->update((int)$id, $request->validated());

            return response()->json([
                'message' => 'Product updated',
                'data' => new ProductResource($updated),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Güncelleme Hatası',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function newProduct(ProductRequest $request, ProductServices $service): JsonResponse
    {
        try {
            $updated = $service->new($request->validated());

            return response()->json([
                'message' => 'Product added',
                'data' => new ProductResource($updated),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Güncelleme Hatası',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function exportProduct(ProductServices $service): JsonResponse
    {
        try {
            $result = $service->exportJSON();
            return response()->json($result);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Export hatası',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
