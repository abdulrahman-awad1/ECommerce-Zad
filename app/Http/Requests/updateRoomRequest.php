<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest  extends FormRequest
{
    public function rules()
    {
        return [
            'room_name' => 'required|string|max:255',
            'category_id' => 'required',
            'description' => 'nullable|string',
            'sku' => 'nullable|string',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'is_featured' => 'sometimes|boolean',
            'is_published'=> 'sometimes|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image'
        ];
    }
}
