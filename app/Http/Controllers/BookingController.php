<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorebookingRequest;
use App\Http\Requests\UpdatebookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
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
    public function store(StorebookingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
        return view('view.booking');
    }

    public function get(Booking $book, Request $request)
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
        return response()->json($bookings);
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
