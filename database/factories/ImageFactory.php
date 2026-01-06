<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // هنا نضع رابط صورة عشوائي من الإنترنت لتجربة التصميم
            'image_path' => 'https://loremflickr.com/640/480/furniture', 
            'room_id' => \App\Models\Room::factory(), // يربط الصورة بغرفة
        ];
    }
}
