<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use App\Models\Facility;
use App\Models\Property;
use App\Rules\OwnsProperty;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function overview($id, $id_facility) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getById($id, Request $request)
    {
        $facility = Facility::where('id_facility', $id)->firstOrFail();
        if ($facility->id_property !== null) {
            $request->merge([
                'id_property' => $facility->id_property,
            ]);
            $request->validate([
                'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Fasilitas",
            "data" => $facility,
        ], 200);
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
    public function store(StoreFacilityRequest $request)
    {
        $request->validate([
            'id_property' => ['required', 'string', 'exists:property,id_property'],
            'facility_name' => ['required', 'string', 'max:255'],
            'facility_type' => ['required', 'string', 'max:50'],
            'facility_desc' => ['required', 'string'],
            'facility_image' => ['required', 'image', 'file'],
        ]);

        $facility = Facility::create([
            'id_property' => $request->id_property,
            'facility_name' => $request->facility_name,
            'facility_type' => $request->facility_type,
            'facility_desc' => $request->facility_desc,
            'facility_image' => '',
        ]);

        if ($request->file('facility_image')) {
            $albumName = $request->file('facility_image')->store('/album');
            $facility->update([
                'facility_image' => $albumName,
            ]);
        }

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menambah data Fasilitas ke Id " . $request->id_property,
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Facility Created',
            ]);
            return redirect()->back()->with('opened', 'Facility');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacilityRequest $request, Facility $facility, $id)
    {
        $request->validate([
            'facility_name' => ['required', 'string', 'max:255'],
            'facility_type' => ['required', 'string', 'max:50'],
            'facility_desc' => ['required', 'string'],
            'facility_image' => ['image', 'file'],
        ]);

        $facility = Facility::where('id_facility', $id)->firstOrFail();
        $request->merge([
            'id_property' => $facility->id_property,
        ]);

        $request->validate([
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
        ]);

        $facility->update([
            'facility_name' => $request->facility_name,
            'facility_type' => $request->facility_type,
            'facility_desc' => $request->facility_desc,
        ]);
        if ($request->file('facility_image')) {
            $albumName = $request->file('facility_image')->store('/album');
            $facility->update([
                'facility_image' => $albumName,
            ]);
        }
        $facility->save();
        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil mengubah data Fasilitas",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Facility Updated',
            ]);
            return redirect()->back()->with('opened', 'Facility');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility, $id, Request $request)
    {
        $facility = Facility::where('id_facility', $id)->firstOrFail();
        $request->merge([
            'id_property' => $facility->id_property,
        ]);

        $request->validate([
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
        ]);

        $facility->delete();
       
        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menghapus data Fasilitas",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Facility Deleted',
            ]);
            return redirect()->back()->with('opened', 'Facility');
        }
    }
}
