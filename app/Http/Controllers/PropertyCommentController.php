<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storeproperty_commentRequest;
use App\Http\Requests\Updateproperty_commentRequest;
use App\Models\property_comment;

class PropertyCommentController extends Controller
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
    public function store(Storeproperty_commentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(property_comment $property_comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(property_comment $property_comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateproperty_commentRequest $request, property_comment $property_comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(property_comment $property_comment)
    {
        //
    }
}
