<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorechannelRequest;
use App\Http\Requests\UpdatechannelRequest;
use App\Models\channel;

class ChannelController extends Controller
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
    public function store(StorechannelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(channel $channel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(channel $channel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatechannelRequest $request, channel $channel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(channel $channel)
    {
        //
    }
}
