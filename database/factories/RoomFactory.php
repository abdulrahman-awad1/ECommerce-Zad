<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // يختار id قسم عشوائي من الأقسام الموجودة، أو ينشئ قسماً جديداً إذا لم يوجد
            'category_id' => $this->faker->numberBetween(1, 1, 4), 
            
            'room_name' => $this->faker->words(3, true),
            
            // إنشاء SKU عشوائي فريد مثل: ZAD-12345
            'sku' => 'ZAD-' . $this->faker->unique()->numberBetween(1000, 9999),
            
            'description' => $this->faker->sentence(15),
            
            // السعر الأساسي
            'price' => $this->faker->randomFloat(2, 5000, 50000), 
            
            // الخصم (يكون مبلغاً مقطوعاً أو 0.00 في أغلب الأحيان)
            'discount' => $this->faker->randomElement([0, 500, 1000, 2000, 5000]),
            
            'is_published' => $this->faker->boolean(80), // 80% احتمال أن تكون منشورة
            'is_featured' => $this->faker->boolean(20),  // 20% احتمال أن تكون مميزة
        ];
    }
}