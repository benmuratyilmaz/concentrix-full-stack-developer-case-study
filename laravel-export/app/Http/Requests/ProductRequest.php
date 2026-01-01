<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $productId = $this->route('product')?->id;

        return [
            'is_active'       => ['sometimes', 'boolean'],
            'name'            => ['sometimes', 'string', 'min:2', 'max:255'],
            'description'     => ['sometimes', 'nullable', 'string'],
            'barcode'         => ['sometimes', 'string', 'max:64', Rule::unique('products', 'barcode')->ignore($productId)],
            'warranty_period' => ['sometimes', 'integer', 'min:0', 'max:120'],
            'list_price'      => ['sometimes', 'numeric', 'min:0', 'max:99999999.99'],
            'sale_price'      => ['sometimes', 'numeric', 'min:0', 'max:99999999.99'],
            'quantity'        => ['sometimes', 'integer', 'min:0', 'max:1000000'],
            'on_sale'         => ['sometimes', 'boolean'],
        ];
    }
}
