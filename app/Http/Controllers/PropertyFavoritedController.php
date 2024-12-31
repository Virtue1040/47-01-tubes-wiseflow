<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storeproperty_favoritedRequest;
use App\Http\Requests\Updateproperty_favoritedRequest;
use App\Models\property_favorited;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PropertyFavoritedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favoritedProperties = property_favorited::where('user_id', Auth::id())->get();

        return view('view.property_favorited.index', [
            'favoritedProperties' => $favoritedProperties,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('view.property_favorited.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeproperty_favoritedRequest $request)
    {
        $validated = $request->validated();

        property_favorited::create([
            'id_property' => $validated['id_property'],
            'id_user' => Auth::id(),
        ]);

        return redirect()->route('property_favorited.index')
            ->with('success', 'Property added to favorites successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(property_favorited $property_favorited): View
    {
        $this->authorizeUser($property_favorited);

        return view('view.property_favorited.show', [
            'property_favorited' => $property_favorited,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(property_favorited $property_favorited): View
    {
        $this->authorizeUser($property_favorited);

        return view('view.property_favorited.edit', [
            'property_favorited' => $property_favorited,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateproperty_favoritedRequest $request, property_favorited $property_favorited)
    {
        $this->authorizeUser($property_favorited);

        $validated = $request->validated();

        $property_favorited->update([
            'property_id' => $validated['id_property'],
        ]);

        return redirect()->route('property_favorited.index')
            ->with('success', 'Favorite property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(property_favorited $property_favorited)
    {
        $this->authorizeUser($property_favorited);

        $property_favorited->delete();

        return redirect()->route('property_favorited.index')
            ->with('success', 'Property removed from favorites successfully.');
    }

    /**
     * Authorize user access for the given property_favorited.
     */
    private function authorizeUser(property_favorited $property_favorited)
    {
        if ($property_favorited->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}