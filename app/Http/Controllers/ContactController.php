<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecontactRequest;
use App\Http\Requests\UpdatecontactRequest;
use App\Models\contact;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
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
    public function store(StorecontactRequest $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30']
        ]);

        $contact = contact::create([
            'id_user' => Auth::user()->id_user,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
        return view('view.contact');
    }

    public function get(Request $request)
    {
        $contact = contact::all();
        return response()->json($contact);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecontactRequest $request, contact $contact)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30']
        ]);

        $contact = contact::find($request->id);
        $id_user = Auth::user()->id_user;
        if ($id_user != $contact->id_user) {
            return response()->json(data:[
                'message' => 'Anda tidak punya akses'
            ], );
        }
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->no_hp = $request->no_hp;
        $contact->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(contact $contact, Request $request)
    {
        $contact = contact::find($request->id);
        $id_user = Auth::user()->id_user;
        if ($id_user != $contact->id_user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $contact->delete();
        
    }
}
