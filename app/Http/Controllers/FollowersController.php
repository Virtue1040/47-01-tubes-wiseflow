<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorefollowersRequest;
use App\Http\Requests\UpdatefollowersRequest;
use App\Models\followers;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FollowersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $followers = followers::where('user_id', Auth::id())->get();

        return view('view.followers.index', [
            'followers' => $followers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('view.followers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorefollowersRequest $request)
    {
        $validated = $request->validated();

        followers::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('followers.index')
            ->with('success', 'Follower added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(followers $follower): View
    {
        $this->authorizeUser($follower);

        return view('view.followers.show', [
            'follower' => $follower,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(followers $follower): View
    {
        $this->authorizeUser($follower);

        return view('view.followers.edit', [
            'follower' => $follower,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatefollowersRequest $request, followers $follower)
    {
        $this->authorizeUser($follower);

        $validated = $request->validated();

        $follower->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
        ]);

        return redirect()->route('followers.index')
            ->with('success', 'Follower updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(followers $follower)
    {
        $this->authorizeUser($follower);

        $follower->delete();

        return redirect()->route('followers.index')
            ->with('success', 'Follower removed successfully.');
    }

    /**
     * Authorize user access for the given follower.
     */
    private function authorizeUser(followers $follower)
    {
        if ($follower->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
