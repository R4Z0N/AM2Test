<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'    =>  $this->id,
            'name'  =>  $this->name,
            'slug'  =>  $this->slug,
            'price' =>  $this->price,
            'currency'  =>  $this->currency,
            'description'   =>  $this->description,
            $this->mergeWhen($request->properties, function () use ($request) {
                $properties = [];
                if(is_array($request->properties)) {
                    foreach($request->properties as $key => $value) {
                        if(isset($this->properties[$key]))
                            $properties[$key] = $this->properties[$key];
                    }
                } else {
                    if(isset($this->properties[$request->properties]))
                        $properties[$request->properties]   =  $this->properties[$request->properties];
                }
                return $properties;
            }),
            'category_id'   =>  $this->category_id,
            'rating'    =>  $this->rating,
            'created_at'    =>  $this->created_at,
            'updated_at'    =>  $this->updated_at,
        ];
    }
}
