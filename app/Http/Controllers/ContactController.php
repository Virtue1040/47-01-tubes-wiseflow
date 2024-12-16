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
    public function index(): View
    {
        return view('view.contact');
    }

    public function getById($id)
    {
        $id_user = Auth::user()->id_user;
        $contact = Contact::where('id_user', $id_user)->where('id_contact', $id)->first();
        return response()->json([
            "success" => "true",
            "message" => "Berhasil mengambil data contact",
            "data" => $contact,
        ], 200);
    }
    public function getAll()
    {
        $contact = Contact::where('id_user', Auth::user()->id_user)->get();
        return response()->json([
            "success" => "true",
            "message" => "Berhasil mengambil data contact",
            "data" => $contact,
        ], 200);
    }

    public function get(Request $request)
    {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $getGuest = Contact::where('id_user', Auth::user()->id_user)
        ->when($filter, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
        })
        ->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })
        ->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Contact",
            "data" => $getGuest,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('view.create_contact');
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
            // 'created_at' => ['required', 'date'],
            // 'updated_at => ['required', 'date']
        ]);

        $contact = contact::create([
            'id_user' => Auth::user()->id_user,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => "true",
                "message" => "Contact succesfully added",
                "data" => $contact,
            ]);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Contact Created',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
        return view('view.contact');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $contact = Contact::findOrFail($id);

        if($contact->id_user != Auth::user()->id_user) {
            abort(403, 'Unauthorized action.');
        }

        return view('view.edit_contact', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecontactRequest $request, contact $contact, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30']
        ]);

        $contact = contact::where('id_contact', $id)->where('id_user', Auth::user()->id_user)->firstOrFail();

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->no_hp = $request->no_hp;
        $contact->save();

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => "true",
                "message" => "Berhasil mengubah data contact",
                "data" => $contact,
            ]);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Contact Updated',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
{
    $contact = Contact::where('id_contact', $id)->where('id_user', Auth::user()->id_user)->firstOrFail();
    $contact->delete();
    if ($request->header('Accept') === 'application/json') {
        return response()->json([
            "success" => "true",
            "message" => "Berhasil mengubah data contact",
            "data" => $contact,
        ]);
    } else {
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Contact Deleted',
        ]);
        return redirect()->back();
    }

}

}
