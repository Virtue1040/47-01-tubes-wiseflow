<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use App\Models\Property_Address;
use App\Models\Property_Contact;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:property-list|property-create|property-edit|property-delete', ['only' => ['index','show']]);
         $this->middleware('permission:property-create', ['only' => ['create','store']]);
         $this->middleware('permission:property-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:property-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        $id_user = Auth::user()->id_user;
        $property = Property::where('id_user_owner', $id_user)->with('album')->get();
        return view('view.property', [
            'property' => $property,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        $request->validate([
            'property_name' => ['required', 'string', 'max:255'],
            'property_desc' => ['required', 'string'],
            'property_category' => ['required', 'string', 'max:50'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:30'],
            'street_name' => ['required', 'string'],
            'province' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'country' => ['required', 'string'],
            'state' => ['required', 'string'],
            'album' => ['required', 'image', 'file'],
        ]);

        $property = Property::create([
            'id_user_owner' => Auth::user()->id_user,
            'property_name' => $request->property_name,
            'property_desc' => $request->property_desc,
            'property_category' => $request->property_category,
        ]);

        $property_address = Property_Address::create([
            'id_property' => $property->id_property,
            'street_name' => $request->property_name,
            'province' => $request->province,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
            'state' => $request->state,
        ]);

        $property_contact = Property_Contact::create([
            'id_property' => $property->id_property,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
        ]);

        if ($request->file('album')) {
            $albumName = $request->file('album')->store('/album');
            $album = Album::create([
                'id_property' => $property->id_property,
                'imagePath' => $albumName,
            ]);
            $property->update([
                'id_cover' => $album->id_album,
            ]);
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Property Created',
        ]);
        return redirect()->route('property');
    }

    /**
     * Display the specified resource.
     */
    public function showDetail(Property $property)
    {
        return view('view/property_detail', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->validate());
        return redirect()->route('properties.index')->with('success', 'Property berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')->with('succes', 'Property berhasil dihapus');
    }
}
