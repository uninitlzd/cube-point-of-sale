<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasAnyRole(['admin', 'owner']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'shop_id' => 'required|exists:shops,id',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|integer',
            'selling_price' => 'required|integer',
            'stockable' => 'required'
        ];
    }
}
