<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
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
        'properties',
        'category_id',
    ]; 


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name'  =>  $this->name,
            'price' =>  $this->price,
            'description'   =>  $this->desciption,
            'category_id'   =>  $this->category_id
        ];
    }

    /**
     * Get the category that owns the apartment.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $searchTerm) {
        return $query
            ->where('name', 'like', "%" . $searchTerm . "%")
            ->orWhere('price', $searchTerm)
            ->orWhere('description', 'like', "%" . $searchTerm . "%")
            ->orWhere('category_id', $searchTerm);
    }
}
