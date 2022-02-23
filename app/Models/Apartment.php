<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'currency',
        'description',
        'category_id',
    ];

    /**
     * Get the category that owns the apartment.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
