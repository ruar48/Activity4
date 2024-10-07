<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    
    protected $fillable = [
        'category_id',
        'product_name',
        'description',
        'price',
        'stock_quantity',
        'image',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
