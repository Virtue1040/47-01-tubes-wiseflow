<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorerentalbumRequest;
use App\Http\Requests\UpdaterentalbumRequest;
use App\Models\rentalbum;
use Illuminate\Http\Request;

class RentalbumController extends Controller
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
    public function store(StorerentalbumRequest $request)
    {
        $request->validate([
            'album' => ['required', 'image', 'file'],
        ]);

        if ($request->file('album')) {
            $albumName = $request->file('album')->store('/album');
            $album = rentalbum::create([
                'id_rent' => $request->id,
                'imagePath' => $albumName,
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Berhasil menambah data Album Rent",
            "data" => $album,
        ], 200);
        
        // if ($request->header('Accept') === 'application/json') {
        //     return response()->json([
        //         "success" => true,
        //         "message" => "Berhasil menambah data Album Rent",
        //     ], 200);
        // } else {
        //     session()->flash('alert', [
        //         'type' => 'success',
        //         'message' => 'Rent Album Created',
        //     ]);
            
        //     session()->flash('success-rentalbum', true);
        //     return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(rentalbum $rentalbum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rentalbum $rentalbum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdaterentalbumRequest $request, rentalbum $rentalbum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rentalbum $rentalbum, Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.id_album' => 'required|integer',
        ]);
        $jsonRequest = $request->json()->all();
        foreach ($jsonRequest['data'] as $data) {
            rentalbum::where('id_album', $data['id_album'])->delete();
        }
        return response()->json([
            "success" => true,
            "message" => "Berhasil menghapus data Rent Album",
        ], 200);
    }
}
