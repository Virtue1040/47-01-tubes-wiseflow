<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentFacilityRequest;
use App\Http\Requests\UpdateRentFacilityRequest;
use App\Models\RentFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentFacilityController extends Controller
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
    public function store(StoreRentFacilityRequest $request, $id)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.id_facility' => 'required|integer',
            'data.*.quantity' => 'required|integer|min:1',
        ]);

        $jsonRequest = $request->json()->all();
        $getLastOrder = RentFacility::orderBy('item_order', 'desc')->first();
        foreach ($jsonRequest['data'] as $key => $data) {
            $rentFacility = new RentFacility();
            $rentFacility->id_rent = $id;
            $rentFacility->id_facility = $data['id_facility'];
            $rentFacility->quantity = $data['quantity'];
            $rentFacility->item_order = $getLastOrder ? $getLastOrder->item_order + 1 : 1;
            $rentFacility->save();

            $jsonRequest['data'][$key]['id_rentfacility'] = $rentFacility->id_rentfacility;
            $jsonRequest['data'][$key]['item_order'] = $rentFacility->item_order;
        }
         
        return response()->json([
            "success" => true,
            "message" => "Berhasil menambahkan data Rent Facility",
            "data" => $jsonRequest,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(RentFacility $rentFacility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentFacility $rentFacility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentFacilityRequest $request, RentFacility $rentFacility, $id)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.id_rentfacility' => 'required|integer',
            'data.*.item_order' => 'integer',
            'data.*.id_facility' => 'integer',
            'data.*.quantity' => 'integer|min:1',
        ]);

        $jsonRequest = $request->json()->all();

        foreach ($jsonRequest['data'] as $key => $data) {
            $getRentFacility = RentFacility::where('id_rentfacility', $data['id_rentfacility'])->where('id_rent', $id)->first();
            if ($getRentFacility->rent->property->id_user_owner != Auth::user()->id_user) {
                return response()->json([
                    "success" => false,
                    "message" => "You dont have access",
                ], 403);
            }
            if ($getRentFacility) {
                $getRentFacility->item_order = $data['item_order'] ?? $getRentFacility->item_order;
                $getRentFacility->id_facility = $data['id_facility'] ?? $getRentFacility->id_facility;
                $getRentFacility->quantity = $data['quantity'] ?? $getRentFacility->quantity;
                $getRentFacility->save();
            }
        }
         
        return response()->json([
            "success" => true,
            "message" => "Berhasil menambahkan data Rent Facility",
            "data" => $jsonRequest,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentFacility $rentFacility, $id, Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.id_rentfacility' => 'required|integer',
        ]);
        $jsonRequest = $request->json()->all();
        foreach ($jsonRequest['data'] as $data) {
            RentFacility::where('id_rentfacility', $data['id_rentfacility'])->where('id_rent', $id)->delete();
        }
        return response()->json([
            "success" => true,
            "message" => "Berhasil menghapus data Rent Facility",
        ], 200);
    }
}
