<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\Property_Address;
use App\Models\Property_Contact;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use App\Models\contact;
use Illuminate\Support\Facades\Auth;
use App\Services\StreamChatService;
use App\Rules\OwnsProperty;
use App\Models\Resident;
use Illuminate\Validation\Rule;


class PropertyController extends Controller
{
    protected $streamChatService;
    function __construct(StreamChatService $streamChatService)
    {
        $this->streamChatService = $streamChatService;
        $this->middleware('role:Admin', ['only' => ['getAllById', 'get']]);
        $this->middleware('permission:property-list|property-create|property-edit|property-delete', ['only' => ['index', 'show', 'getById']]);
        $this->middleware('permission:property-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:property-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:property-delete', ['only' => ['destroy']]);
    }

    public function getOwnType()
    {
        $getCategory = Property::select('property_category')->where('id_user_owner', Auth::user()->id_user)->distinct()->get();
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Category",
            "data" => $getCategory,
        ], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_user = Auth::user()->id_user;
        $property = Property::where('id_user_owner', $id_user)->with('album')->with('rent')
            ->get()
            ->map(function ($property) {
                $property->total_rent = $property->rent->count();
                $property->total_available = $property->rent->where('availability', 1)->count();
                return $property;
            });
        $getCategory = Property::select('property_category')->where('id_user_owner', Auth::user()->id_user)->distinct()->get();
        return view('view.property.property', [
            'property' => $property,
            'propertyCategory' => $getCategory
        ]);
    }

    public function getAllById(Request $request, $id)
    {
        $id_user = Auth::user()->id_user;
        $property = Property::where('id_user_owner', $id_user)->with('album')->get();
        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil mengambil data Property",
                "data" => $property,
            ]);
        } else {
            return view('view.property.property', [
                'property' => $property,
            ]);
        }
    }

    public function getById($id)
    {
        $id_user = Auth::user()->id_user;
        $property = Property::where('id_user_owner', $id_user)->where('id_property', $id)->with('album')->get();
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Property",
            "data" => $property,
        ], 200);
    }

    public function get()
    {
        $property = Property::with('album')->get();
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Property",
            "data" => $property,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        $request->validate([
            'property_name' => ['required', 'string', 'max:255'],
            'property_desc' => ['required', 'string'],
            'property_category' => ['required', 'string', 'max:50', Rule::in(config('enums.property_category'))],
            'contact' => ['nullable', 'integer', 'exists:contacts,id_contact', 'required_without:contact_name', 'required_without:contact_phone', 'required_without_all:contact_name,contact_phone'],
            'contact_name' => ['nullable', 'string', 'max:255', 'required_without:contact'],
            'contact_phone' => ['nullable', 'string', 'max:30', 'required_without:contact'],
            'street_name' => ['required', 'string'],
            'province' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'country' => ['required', 'string'],
            'state' => ['required', 'string'],
            'album' => ['required', 'image', 'file'],
            'longitude' => ['required', 'string'],
            'latitude' => ['required', 'string'],
        ]);

        

        $getContact = contact::where('id_contact', $request->contact)->where('id_user', Auth::user()->id_user)->first();

        $property = Property::create([
            'id_user_owner' => Auth::user()->id_user,
            'property_name' => $request->property_name,
            'property_desc' => $request->property_desc,
            'property_category' => $request->property_category,
        ]);

        $property_address = Property_Address::create([
            'id_property' => $property->id_property,
            'street_name' => $request->street_name,
            'province' => $request->province,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
            'state' => $request->state,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        $contact_name = $request->contact_name;
        $contact_phone = $request->contact_phone;

        if ($getContact !== null) {
            $contact_name = $getContact->name;
            $contact_phone = $getContact->no_hp;
        }

        $property_contact = Property_Contact::create([
            'id_property' => $property->id_property,
            'contact_name' => $contact_name,
            'contact_phone' => $contact_phone,
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

        $channel = $this->streamChatService->createChannel(
            'team',
            [strval(Auth::user()->id_user)],
            $request->input('name', $request->property_name)
        );

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menambah data Property",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Property Created',
            ]);
            return redirect()->route('property');
        }
    }

    /**
     * Display the specified resource.
     */
    public function showDetail(Property $property, $id)
    {
        $getProperty = Property::where('id_property', $id)->first();
        return view('view.property.detail.detail', ['property' => $getProperty]);
    }

    public function getGuests(Request $request, $id)
    {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $request->merge([
            'id_property' => $id,
        ]);
        $request->validate([
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
        ]);
        $getGuest = Resident::select(
            'residents.id_resident',
            DB::raw("CONCAT(contact_information.first_name, ' ', contact_information.last_name) as full_name"),
            'bookings.orderNumber',
            'bookings.status',
            'bookings.id_booking',
            'rents.rent_name'
        )
            ->join('contact_information', 'residents.id_user', '=', 'contact_information.id_user')
            ->join('bookings', 'residents.id_booking', '=', 'bookings.id_booking')
            ->join('rents', 'residents.id_rent', '=', 'rents.id_rent')
            ->where('residents.id_property', $id)
            ->when($filter, function ($query, $search) {
                $query->where('id_resident', 'like', "%{$search}%")
                    ->orWhere('id_booking', 'like', "%{$search}%")
                    ->orWhere('orderNumber', 'like', "%{$search}%")
                    ->orWhere('rent_name', 'like', "%{$search}%")
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
            "message" => "Berhasil mengambil data Guest Property",
            "data" => $getGuest,
        ], 200);
    }

    public function showCalendar($id)
    {
        $getProperty = Property::where('id_property', $id)->first();
        return view('view.property.detail.calendar', ['property' => $getProperty]);
    }

    public function showGuest($id)
    {
        $getProperty = Property::where('id_property', $id)->first();
        return view('view.property.detail.guest', ['property' => $getProperty]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property, $id, Request $request)
    {
        $request->merge([
            'id_property' => $id,
        ]);
        $request->validate([
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
        ]);
        $getProperty = Property::where('id_property', $id)->first();
        return view('view.property.detail.detail-edit', ['property' => $getProperty]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property, $id)
    {
        $request->merge([
            'id_property' => $id,
        ]);
        $request->validate([
            'property_name' => ['required', 'string', 'max:255'],
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
            'property_desc' => ['required', 'string'],
            'property_category' => ['required', 'string', 'max:50', Rule::in(config('enums.property_category'))],
            // 'contact' => ['nullable','integer', 'exists:contacts,id_contact','required_without:contact_name','required_without:contact_phone', 'required_without_all:contact_name,contact_phone'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'street_name' => ['required', 'string'],
            'province' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'country' => ['required', 'string'],
            'state' => ['required', 'string'],
            'id_cover' => ['required', 'integer', 'exists:albums,id_album'],
            'longitude' => ['required', 'string'],
            'latitude' => ['required', 'string'],
        ]);

        $getProperty = Property::where('id_property', $id)->first();
        $getContact = Property_Contact::where('id_property', $id)->first();
        $getAddress = Property_Address::where('id_property', $id)->first();

        $getProperty->update([
            'property_name' => $request->property_name,
            'property_desc' => $request->property_desc,
            'property_category' => $request->property_category,
            'id_cover' => $request->id_cover,
        ]);

        $getAddress->update([
            'street_name' => $request->street_name,
            'province' => $request->province,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
            'state' => $request->state,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        $getContact->update([
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
        ]);

        $getProperty->save();
        $getAddress->save();
        $getContact->save();

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil mengupdate data Property",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Property Updated',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property, Request $request, $id)
    {
        $request->merge([
            'id_property' => $id
        ]);

        $request->validate([
            'id_property' => ['required', 'integer', 'exists:property,id_property', new OwnsProperty],
            'verification' => ['required', 'string'],
        ]);

        $property = Property::find($id);

        if ($request->verification !== $property->property_name) {
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

        $property->delete();

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menghapus data Property",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Property Deleted',
            ]);
            return redirect()->route('property');
        }
    }
}
