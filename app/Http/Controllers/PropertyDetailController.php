<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storeproperty_detailRequest;
use App\Http\Requests\Updateproperty_detailRequest;
use App\Models\property_detail;

class PropertyDetailController extends Controller
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
    public function store(Storeproperty_detailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(property_detail $property_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(property_detail $property_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateproperty_detailRequest $request, property_detail $property_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(property_detail $property_detail)
    {
        //
    }
}
