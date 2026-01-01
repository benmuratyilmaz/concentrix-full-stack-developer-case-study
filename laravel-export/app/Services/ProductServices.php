<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Carbon\CarbonImmutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class ProductServices
{

    public function list(bool $isActive, bool $onSale, int $limit): LengthAwarePaginator
    {
        $query = Product::query();

        if (!$isActive) {
            $query->where("is_active", 0);
        }

        if (!$onSale) {
            $query->where("on_sale", 0);
        }

        $products = $query->orderByDesc('id')->paginate($limit);

        return  $products;
    }

    public function detail(int $productId): ProductResource
    {
        $product = Product::query()->findOrFail($productId);
        return new ProductResource($product);
    }

    public function new(array $data): Product
    {
        $requiredFields = [
            'name',
            'barcode',
            'list_price',
            'sale_price',
        ];

        $missing = [];
        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $data) || $data[$field] === null) {
                $missing[$field] = ["{$field} alanı zorunludur."];
            }
        }

        if (!empty($missing)) {
            throw ValidationException::withMessages($missing);
        }

        if ((float)$data['sale_price'] > (float)$data['list_price']) {
            throw ValidationException::withMessages([
                'sale_price' => ['sale_price list_price değerinden büyük olamaz.'],
            ]);
        }

        $product = Product::query()->create($data);
        return $product->fresh();
    }

    public function update(int $id, array $data): Product
    {
        $product = Product::query()->findOrFail($id);

        $listPrice = array_key_exists('list_price', $data)
            ? (float) $data['list_price']
            : (float) $product->list_price;

        $salePrice = array_key_exists('sale_price', $data)
            ? (float) $data['sale_price']
            : (float) $product->sale_price;

        if ($salePrice > $listPrice) {
            throw ValidationException::withMessages([
                'sale_price' => ['sale_price list_price değerinden büyük olamaz.'],
            ]);
        }


        $product->fill($data);
        $product->save();

        return $product->fresh();
    }

    public function exportJSON(): array
    {
        $createdAt = CarbonImmutable::now();
        $jsonNameDate =  $createdAt->format('Ymd_Hi');
        $path = "storage/app/exports/products_{$jsonNameDate}.json";

        $products = Product::query()->orderBy('id')->get();
        $count = $products->count();
        $json = $products->toJson(JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        if ($json === null || $json === false) {
            throw new RuntimeException('JSON başarısız.');
        }

        $storage =  Storage::disk('local');
        $write = $storage->put($path, $json);

        if (!$write) {
            throw new RuntimeException('Dosya yazma başarısız oldu.');
        }

        if (!$storage->exists($path)) {
            throw new RuntimeException('Dosya yazıldıktan sonra bulunamadı.');
        }

        return [
            'file_path'    => storage_path('app/' . $path),
            'record_count' => $count,
            'created_at'   => $createdAt->toIso8601String(),
        ];
    }
}
