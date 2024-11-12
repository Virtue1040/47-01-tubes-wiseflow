<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecontactRequest;
use App\Http\Requests\UpdatecontactRequest;
use App\Models\contact;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
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
    public function store(StorecontactRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
        return view('view.contact');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecontactRequest $request, contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(contact $contact)
    {
        //
    }
}
