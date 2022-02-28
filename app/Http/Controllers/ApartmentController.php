<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Resources\ApartmentResource;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApartmentUpdateSubscribersMail;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @return App\Http\Resources\ApartmentResource
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            's' =>  'nullable|string',
            'properties'    =>  'nullable',
            'orderBy' => 'nullable|array',
            'orderBy.*' => 'in:asc,desc',
            'category_id' => ['nullable', 'integer', 'exists:App\Models\Category,id'],
        ]);

        $apartments = Apartment::search($request->s)
        ->when($request->category_id, function ($query, $category_id) {
            $query->whereHas('category', function ($query) use ($category_id) {
                $query->where('id', $category_id)->orWhere('parent_id', $category_id);
            });
        })
        ->when($request->orderBy, function ($query, $orderBy) {
            foreach($orderBy ?? [] as $key => $value) {
                $query->orderBy($key, $value);
            }
        })
        ->paginate(20);

        return ApartmentResource::collection($apartments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApartmentRequest  $request
     * @return App\Http\Resources\ApartmentResource
     */
    public function store(StoreApartmentRequest $request) {
        $apartment = Apartment::create($request->validated());

        return new ApartmentResource($apartment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return $apartment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApartmentRequest  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $apartment->update($request->validated());
        
        return $apartment;
    }

    /**
     * Rating apartment
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return App\Http\Resources\ApartmentResource
     */
    public function rating(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'rating' =>  'required|numeric|between:1,5',
        ]);

        $rating = $apartment->ratings()->firstWhere('email', $request->user_email);

        if($rating)
            return (new ApartmentResource($apartment))
                ->additional([
                    'message' => 'You have already rated this apartment.'
                ])
                ->response()
                ->setStatusCode(\Illuminate\Http\Response::HTTP_CONFLICT);

        $rating = $apartment->ratings()->create([
            'email' =>  $request->user_email,
            'rating'    =>  $request->rating
        ]);

        $apartment->updateRating();

        return (new ApartmentResource($apartment))
            ->additional([
                'message' => 'You have successfully rated the apartment.'
            ])
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);

        return new ApartmentResource($apartment);
    }

    /**
     * Subscribe to apartment
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return App\Http\Resources\ApartmentResource
     */
    public function subscribe(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $subscribe = $apartment->subscribers()->firstWhere('email', $request->user_email);

        if($subscribe) {
            $subscribe->price = $request->price;
            $subscribe->save();
            return (new ApartmentResource($apartment))
                ->additional([
                    'message' => 'You have successfully updated your subscription to the apartment.'
                ])
                ->response()
                ->setStatusCode(\Illuminate\Http\Response::HTTP_ACCEPTED);
        }

        $rating = $apartment->subscribers()->create([
            'email' =>  $request->user_email,
            'price'    =>  $request->price
        ]);

        return (new ApartmentResource($apartment))
            ->additional([
                'message' => 'You have successfully subscribed to the apartment.'
            ])
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);

        return new ApartmentResource($apartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        return $apartment->delete();
    }
}
