<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorefollowingRequest;
use App\Http\Requests\UpdatefollowingRequest;
use App\Models\following;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FollowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $followings = following::where('user_id', Auth::id())->get();

        return view('view.following.index', [
            'followings' => $followings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('view.following.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorefollowingRequest $request)
    {
        $validated = $request->validated();

        following::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('following.index')
            ->with('success', 'Following added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(following $following): View
    {
        $this->authorizeUser($following);

        return view('view.following.show', [
            'following' => $following,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(following $following): View
    {
        $this->authorizeUser($following);

        return view('view.following.edit', [
            'following' => $following,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatefollowingRequest $request, following $following)
    {
        $this->authorizeUser($following);

        $validated = $request->validated();

        $following->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
        ]);

        return redirect()->route('following.index')
            ->with('success', 'Following updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(following $following)
    {
        $this->authorizeUser($following);

        $following->delete();

        return redirect()->route('following.index')
            ->with('success', 'Following removed successfully.');
    }

    /**
     * Authorize user access for the given following.
     */
    private function authorizeUser(following $following)
    {
        if ($following->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
