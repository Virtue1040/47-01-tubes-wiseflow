<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storechannel_memberRequest;
use App\Http\Requests\Updatechannel_memberRequest;
use App\Models\channel_member;

class ChannelMemberController extends Controller
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
    public function store(Storechannel_memberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(channel_member $channel_member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(channel_member $channel_member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatechannel_memberRequest $request, channel_member $channel_member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(channel_member $channel_member)
    {
        //
    }
}
