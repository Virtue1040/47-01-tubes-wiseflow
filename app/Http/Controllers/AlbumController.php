<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorealbumRequest;
use App\Http\Requests\UpdatealbumRequest;
use App\Models\Album;
use App\Rules\OwnsProperty;
use Illuminate\Http\Request;

class AlbumController extends Controller
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
    public function store(StorealbumRequest $request)
    {
        $request->validate([
            'album' => ['required', 'image', 'file'],
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
        ]);

        if ($request->file('album')) {
            $albumName = $request->file('album')->store('/album');
            $album = Album::create([
                'id_property' => $request->id_property,
                'imagePath' => $albumName,
            ]);
        }

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menambah data Album Property",
                "data" => $album,
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Album Created',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatealbumRequest $request, album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, album $album, $id)
    {
        $getAlbum = album::find($id);
        $getPropertyId = $getAlbum->id_property;

        $request->merge([
            'id_property' => $getPropertyId
        ]);

        $request->validate([
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
        ]);

        $getAlbum->delete();

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menghapus data Property Album",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Album Deleted',
            ]);
            return redirect()->back();
        }


    }
}
