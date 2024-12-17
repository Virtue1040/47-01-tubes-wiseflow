<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIuranRequest;
use App\Http\Requests\UpdateIuranRequest;
use App\Models\Iuran;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Property;


class IuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $iurans = Iuran::where('id_iuran', Auth::user()->id_iuran)->get();
        $getProperty = Property::where('id_property', $id)->first();
        return view('view.property.detail.iuran', ['iurans' => $iurans, 'property' => $getProperty]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('view.property.create_iuran');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIuranRequest $request)
    {
        $request->validate([
            'nominal_iuran' => ['required', 'numeric', 'min:0'],
            'iuran_desc' => ['required', 'string', 'max:255'],
            'id_property' => ['required', 'numeric', 'max:10'],
            'type_iuran' => ['required', 'char', 'max:20'],
            'orderNumber' => ['required', 'numeric', 'max:10'],
            'status' => ['required', 'char', 'max:20'],
            'tanggal_iuran' => ['required', 'date'],
            'tenggat_iuran' => ['required', 'date']
        ]);

        $iuran = Iuran::create([
            'id_iuran' => Auth::user()->id_iuran,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return redirect()->route('iurans.index')->with('success', 'Iuran created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Iuran $iuran): View
    {
        if ($iuran->id_iuran != Auth::user()->id_iuran) {
            abort(403, 'Unauthorized action.');
        }
        return view('view.property.show_iuran', ['iuran' => $iuran]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $iuran = Iuran::findOrFail($id);

        if ($iuran->id_iuran != Auth::user()->id_iuran) {
            abort(403, 'Unauthorized action.');
        }

        return view('view.property.edit_iuran', ['iuran' => $iuran]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIuranRequest $request, $id)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $iuran = Iuran::findOrFail($id);

        if (Auth::user()->id_iuran != $iuran->id_iuran) {
            return response()->json([
                'message' => 'Unauthorized access'
            ], 403);
        }

        $iuran->amount = $request->amount;
        $iuran->description = $request->description;
        $iuran->save();

        return redirect()->route('iurans.index')->with('success', 'Iuran updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $iuran = Iuran::findOrFail($id);

        if (Auth::user()->id_iuran != $iuran->id_iuran) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $iuran->delete();

        return redirect()->route('iurans.index')->with('success', 'Iuran deleted successfully.');
    }
}
