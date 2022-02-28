<?php

namespace App\Http\Controllers;

use App\Models\ApartmentField;
use App\Http\Requests\StoreApartmentFieldRequest;
use App\Http\Requests\UpdateApartmentFieldRequest;

class ApartmentFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApartmentFieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartmentFieldRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApartmentField  $apartmentField
     * @return \Illuminate\Http\Response
     */
    public function show(ApartmentField $apartmentField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApartmentField  $apartmentField
     * @return \Illuminate\Http\Response
     */
    public function edit(ApartmentField $apartmentField)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApartmentFieldRequest  $request
     * @param  \App\Models\ApartmentField  $apartmentField
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentFieldRequest $request, ApartmentField $apartmentField)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApartmentField  $apartmentField
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApartmentField $apartmentField)
    {
        //
    }
}
