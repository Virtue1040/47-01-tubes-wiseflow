<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorerenttagRequest;
use App\Http\Requests\UpdaterenttagRequest;
use App\Models\renttag;
use Illuminate\Http\Request;

class RenttagController extends Controller
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
    public function store(StorerenttagRequest $request, $id)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.tag' => 'required|string|max:30',
        ]);

        $jsonRequest = $request->json()->all();
        foreach ($jsonRequest['data'] as $key => $data) {
            $rentTag = new renttag();
            $rentTag->id_rent = $id;
            $rentTag->tag = $data['tag'];
            $rentTag->save();

            $jsonRequest['data'][$key]['id_tag'] = $rentTag->id_tag;
        }
         
        return response()->json([
            "success" => true,
            "message" => "Berhasil menambahkan data Rent Tag",
            "data" => $jsonRequest,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function get(renttag $renttag, $id)
    {
        $gettag = $renttag::where('id_rent', $id)->get();
        dd($gettag);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(renttag $renttag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdaterenttagRequest $request, renttag $renttag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.id_tag' => 'required|integer',
        ]);
        $jsonRequest = $request->json()->all();
        foreach ($jsonRequest['data'] as $data) {
            renttag::where('id_tag', $data['id_tag'])->where('id_rent', $id)->delete();
        }
        return response()->json([
            "success" => true,
            "message" => "Berhasil menghapus data Rent Tag",
        ], 200);
    }
}
