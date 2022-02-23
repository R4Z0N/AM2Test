<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory, Searchable;

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

}
