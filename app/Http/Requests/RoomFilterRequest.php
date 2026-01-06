<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomFilterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category' => 'array',
            'category.*' => 'exists:categories,id',
            'is_featured' => 'nullable',
            'has_discount' => 'nullable',
            'sort' => 'nullable|in:price_asc,price_desc,latest'
        ];
    }
}
