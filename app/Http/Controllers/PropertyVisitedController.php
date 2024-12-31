<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Storeproperty_visitedRequest;
use App\Http\Requests\Updateproperty_visitedRequest;
use App\Models\PropertyVisited;

class PropertyVisitedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyVisited = PropertyVisited::all();
        return response()->json($propertyVisited);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('property_visited.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_user' => 'required|integer',
            'id_property' => 'required|integer',
        ]);

        $propertyVisited = PropertyVisited::create($validatedData);
        return response()->json(['message' => 'Property visited created successfully', 'data' => $propertyVisited]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $propertyVisited = PropertyVisited::findOrFail($id);
        return response()->json($propertyVisited);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $propertyVisited = PropertyVisited::findOrFail($id);
        return view('property_visited.edit', compact('propertyVisited'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_user' => 'required|integer',
            'id_property' => 'required|integer',
        ]);

        $propertyVisited = PropertyVisited::findOrFail($id);
        $propertyVisited->update($validatedData);

        return response()->json(['message' => 'Property visited updated successfully', 'data' => $propertyVisited]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $propertyVisited = PropertyVisited::findOrFail($id);
        $propertyVisited->delete();

        return response()->json(['message' => 'Property visited deleted successfully']);
    }
}