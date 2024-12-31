<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Rent;
use App\Models\rentalbum;
use App\Rules\OwnsProperty;
use App\Models\Resident;

class RentController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:rent-list|rent-create|rent-edit|rent-delete', ['only' => ['index','overview']]);
         $this->middleware('permission:rent-create', ['only' => ['create','store']]);
         $this->middleware('permission:rent-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:rent-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $user = Auth::user();
        $getProperty = Property::where('id_property', $id)->first();
        return view('view.property.detail.rent', [
            'property' => $getProperty,
        ]);
    }

    public function getById($id)
    {
        $rent = Rent::where('id_rent', $id)->with("getRentTag")->with("album")->first();
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Rent",
            "data" => $rent,
        ], 200);
    }

    public function get()
    {
        $rent = Rent::all();
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Rent",
            "data" => $rent,
        ], 200);
    }

    public function getGuest(Request $request, $id) {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $getRent = Rent::where('id_rent', $id)->first();
        $request->merge([
            'id_property' => $getRent->id_property,
        ]);
        $request->validate([
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
        ]);
        // ->orWhere('id_rent', $id)
        $getGuest = Resident::select(
            'residents.id_resident', 
            DB::raw("CONCAT(contact_information.first_name, ' ', contact_information.last_name) as full_name"),
            'bookings.status',
            'bookings.checkin as check_in',
            'bookings.checkout as check_out'
        )
        ->join('contact_information', 'residents.id_user', '=', 'contact_information.id_user')
        ->join('bookings', 'residents.id_booking', '=', 'bookings.id_booking')
        ->where('residents.id_property', $getRent->id_property)
        ->when($filter, function ($query, $search) {
            $query->where('id_resident', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        })
        // ->when($groupBy, function ($query, $groupBy) {
        //     $query->groupBy($groupBy)
        // });
        ->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })
        ->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Resident",
            "data" => $getGuest,
        ], 200);
    }

    public function getHasProperty($id)
    {
        $user = Auth::user();
        Property::where('id_user_owner', $user->id_user)->where('id_property', $id)->firstOrFail();
        $rent = Rent::where('id_property', $id)->get();
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Rent",
            "data" => $rent,
        ], 200);
    }

    public function overview($id, $id_rent = null) {
        $getProperty = Property::where('id_property', $id)->first();
        $getRent = Rent::where('id_rent', $id_rent)->where('id_property', $id)->first();
        return view('view.property.detail.rent', [
            'property' => $getProperty,
            'rent' => $getRent,
            'facilities' => Facility::where('id_property', $id)
            ->orWhereNull('id_property') 
            ->get() 
            ->groupBy(function ($item) {
                return strtolower($item->facility_type); 
            }),
        ]);
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
    public function updateCover(StoreRentRequest $request, $id) {
        $userid = Auth::user()->id_user;
        $getRent = Rent::find($id);
        $request->validate([
            'id_cover' => ['required', 'integer', 'exists:rentalbums,id_album'],
        ]);

        if ($getRent->id_cover == $request->id_cover) {
            return response()->json([
                "success" => false,
                "message" => "Cover sudah sama",
            ], 400);
        }

        $getRent->id_cover = $request->id_cover;
        $getRent->save();

        $getRent->imagePath = $getRent->album->imagePath;
        
        return response()->json([
            "success" => true,
            "message" => "Berhasil menambah data Rent Cover ke Id " . $request->id_cover,
            "data" => $getRent,
        ], 200);

        // if ($request->header('Accept') === 'application/json') {
        //     return response()->json([
        //         "success" => true,
        //         "message" => "Berhasil menambah data Rent Cover ke Id " . $request->id_cover,
        //     ], 200);
        // } else {
        //     session()->flash('alert', [
        //         'type' => 'success',
        //         'message' => 'Rent Cover Changed',
        //     ]);
        //     return redirect()->back();
        // }
    }

    public function store(StoreRentRequest $request)
    {
        $request->validate([
            'id_property' => ['required', 'string', 'exists:property,id_property'],
            'rent_name' => ['required', 'string', 'max:255'],
            'rent_desc' => ['required', 'string'],
            'rent_price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $rent = Rent::create([
            'id_property' => $request->id_property,
            'rent_name' => $request->rent_name,
            'rent_desc' => $request->rent_desc,
            'rent_price' => $request->rent_price,
            'stock' => $request->stock,
            'availability' => 0,
        ]);

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menambah data Rent ke Id " . $request->id_property,
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Rent Created',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentRequest $request, Rent $rent, $id)
    {
        $request->validate([
            'rent_name' => ['string', 'max:255'],
            'rent_desc' => ['string'],
            'rent_price' => ['integer', 'min:0'],
            'id_cover' => ['integer', 'exists:rentalbums,id_album'],
            'availability' => ['boolean'],
            'stock' => ['integer', 'min:0'],
        ]);

        $rent = Rent::find($id);
        foreach ($request->all() as $key => $value) {
            $rent->$key = $value;
        }
        $rent->save();
        
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengubah data Rent",
            "data" => $rent,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rent $rent, Request $request, $id)
    {
        $request->validate([
            'id_property' => ['required', 'string', 'exists:property,id_property'],
            'id_rent' => ['required', 'integer', 'exists:rents,id_rent'],
            'verification' => ['required', 'string'],
        ]);

        $rent = Rent::where('id_property', $request->id_property)->where('id_rent', $id)->firstOrFail();

        if ($request->verification !== $rent->rent_name) {
            if ($request->header('Accept') === 'application/json') {
                return response()->json([
                    "success" => false,
                    "message" => "Verifikasi gagal",
                ], 400);
            } else {
                session()->flash('alert', [
                    'type' => 'error',
                    'message' => 'Verifikasi Gagal',
                ]);
                return redirect()->back();
            }
        }

        $rent->delete();
       
        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menghabus data Fasilitas ke Id ",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Rent Deleted',
            ]);
            return redirect()->back();
        }
    }
}
