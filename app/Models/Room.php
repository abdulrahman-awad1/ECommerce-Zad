<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    
    public function category(): BelongsTo
    {
        
        return $this->belongsTo(Category::class); 
    }

    
    public function images(): HasMany
    {
       
        return $this->hasMany(Image::class); 
    }
    
    

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}