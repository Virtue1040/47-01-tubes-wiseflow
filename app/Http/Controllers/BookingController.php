<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorebookingRequest;
use App\Http\Requests\UpdatebookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('view.booking');
    }

    public function index2()
    {
        return view('view.all-booking');
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
    public function store(StorebookingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
        
    }

    public function get(Booking $book, Request $request)
    {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $bookings = $book::select(
            'id_booking',
            'bookings.id_user',
            'bookings.id_property',
            'bookings.id_rent',
            'property_name',
            'rent_name',
            'checkin',
            'checkout',
            'status',
        )
        ->join('property', 'bookings.id_property', '=', 'property.id_property')
        ->join('rents', 'bookings.id_rent', '=', 'rents.id_rent')
        ->where('id_user', Auth::user()->id_user)
        ->when($filter, function ($query, $search) {
            $query->where('status', 'like', "%{$search}%")
                  ->orWhere('id_booking', 'like', "%{$search}%");
        })->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Booking",
            "data" => $bookings,
        ], 200);
    }

    public function getAll(Booking $book, Request $request)
    {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $bookings = $book::query()
        ->when($filter, function ($query, $search) {
            $query->where('status', 'like', "%{$search}%")
                  ->orWhere('id_booking', 'like', "%{$search}%");
        })->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Booking",
            "data" => $bookings,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
