<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storeproperty_favoritedRequest;
use App\Http\Requests\Updateproperty_favoritedRequest;
use App\Models\property_favorited;

class PropertyFavoritedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeproperty_favoritedRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(property_favorited $property_favorited)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(property_favorited $property_favorited)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateproperty_favoritedRequest $request, property_favorited $property_favorited)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(property_favorited $property_favorited)
    {
        //
    }
}
