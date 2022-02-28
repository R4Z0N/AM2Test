<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
        // return $this->hasManyThrough(Category::class, Category::class);
    }


    public function scopeSearch($query, $searchTerm) {
        return $query
        ->where('name', 'like', "%" . $searchTerm . "%")
        ->orWhere('price', $searchTerm)
        ->orWhere('description', 'like', "%" . $searchTerm . "%")
        ->orWhere('category_id', $searchTerm);
    }

    public function ratings() {
        return $this->hasMany(ApartmantRating::class);
    }

    public function updateRating()
    {
        $this->rating = $this->ratings()->avg('rating');
        $this->save();
    }


    public function subscribers() {
        return $this->hasMany(ApartmentSubscriber::class);
    }

    /**
     * Get the apartment's price.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if(request()->hasHeader('X-CURRENCY-CODE')){
                    $fixerResponse = Cache::remember('fixerApi', 86400, function () {
                        return Http::get('http://data.fixer.io/api/latest', [
                            'access_key' => '87c289bf1e6d799f1fc5ce4ef7854288',
                            'format' => '1',
                        ])->json();
                    });

                    if($fixerResponse['success'] === true)
                    {
                        if(array_key_exists(request()->header('X-CURRENCY-CODE'), $fixerResponse['rates']) && array_key_exists($this->currency, $fixerResponse['rates'])) {
                                $price = $value / $fixerResponse['rates'][$this->currency] * $fixerResponse['rates'][request()->header('X-CURRENCY-CODE')];
                                $this->currency = request()->header('X-CURRENCY-CODE');
                                return number_format($price, 2, '.', '');
                                
                        }
                    }
                }
                return $value;
            }
        );
    }
}
