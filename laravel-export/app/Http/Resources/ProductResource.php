<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_active' => (bool)$this->is_active,
            'name' => $this->name,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'warranty_period' => $this->warranty_period,
            'list_price' => (float)$this->list_price,
            'sale_price' => (float)$this->sale_price,
            'quantity' => (int)$this->quantity,
            'on_sale' => (bool)$this->on_sale,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
