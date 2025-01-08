<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIuranRequest;
use App\Http\Requests\UpdateIuranRequest;
use App\Models\Iuran;
use App\Models\iuran_pay;
use App\Models\Order;
use App\Models\orderdetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;

class IuranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("view.bill");
    }

    public function getbills(Request $request) {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $iuran = Iuran::select(
            'iurans.id_iuran',
            'property.id_property',
            'property.property_name',
            'type_iuran',
            'iuran_desc',
            'nominal_iuran',
            DB::raw("CASE WHEN iuran_pays.id_iuran IS NOT NULL THEN 'Sudah Lunas' ELSE 'Belum Lunas' END AS status"),
            'tanggal_iuran',
            'tenggat_iuran'
        )
        ->join('property', 'iurans.id_property', '=', 'property.id_property')
        ->leftJoin('iuran_pays', 'iurans.id_iuran', '=', 'iuran_pays.id_iuran')
        ->where('iuran_pays.id_user', Auth::user()->id_user)
        ->when($filter, function ($query, $search) {
            $query->where('status', 'like', "%{$search}%")
                  ->orWhere('iuran_desc', 'like', "%{$search}%")
                  ->orWhere('type_iuran', 'like', "%{$search}%")
                  ->orWhere('nominal_iuran', 'like', "%{$search}%");
        })->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Iuran",
            "data" => $iuran,
        ], 200);
    }

    public function paybill(Request $request, $id) {
        $getIuran = iuran::where('id_iuran', $id)->first();
        if ($getIuran->status == "Belum Lunas") {
            $makeOrder = "ORDER-IURAN-" . uniqid() . time();
            $price = $getIuran->nominal_iuran;
            $order = Order::create([
                'orderNumber' => $makeOrder,
                'id_user' => Auth::user()->id_user,
            ]);
    
            $orderdetails = orderdetails::create([
                'orderNumber' => $makeOrder,
                'checkNumber' => 'PAYMENT-' . time(),
                'status' => 'pending',
                'type_order' => 'iuran',
                'id_item' => $getIuran->id_iuran,
                'quantity' => 1,
                'total_order' => $price,
            ]);

            $transaction_details = array(
                'order_id'    => $makeOrder,
                'gross_amount'  => $price,
              );
    
            $items = array(
                array(
                    'id'       => $getIuran->id_iuran,
                    'price'    => $price,
                    'quantity' => 1,
                    'name'     => 'Iuran Pay Bills ' . $getIuran->iuran_desc
                ),
            );
    
            $token = Snap::getSnapToken([
                'transaction_details' => $transaction_details,
                'item_details'        => $items,
            ]);

            return response()->json([
                "success" => true,
                "message" => "Berhasil membuat data Iuran Pembayaran",
                "data" => $order,
                "token" => $token,
            ], 200);

            // $getTotalIuranPay = iuran_pay::where('id_iuran', $getIuran->id_iuran)->sum("nominal");
            // if ($getIuran->nominal_iuran >= $getTotalIuranPay) {
            //     $getIuran->status = "Sudah Lunas";
            //     $getIuran->save();
            // }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id): View
    {
        $iurans = Iuran::where('id_iuran', Auth::user()->id_iuran)->get();
        $getProperty = Property::where('id_property', $id)->first();
        return view('view.property.detail.iuran', ['iurans' => $iurans, 'property' => $getProperty]);
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
            'type_iuran' => ['required', 'string', 'max:20'],
            'tenggat_iuran' => ['required', 'date:Y-m-d'],
        ]);

        $iuran = Iuran::create([
            'nominal_iuran' => $request->nominal_iuran,
            'iuran_desc' => $request->iuran_desc,
            'id_property' => $request->id_property,
            'type_iuran' => $request->type_iuran,
            'status' => "Belum Lunas",
            'tanggal_iuran' => $request->tenggat_iuran,
            'tenggat_iuran' => $request->tenggat_iuran,
        ]);

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menambah iuran",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Iuran Added',
            ]);
            return redirect()->back();
        }
    }

    public function get(Request $request)
    {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $iuran = Iuran::select(
            'id_iuran',
            'property.id_property',
            'property.property_name',
            'type_iuran',
            'iuran_desc',
            'nominal_iuran',
            'status',
            'tanggal_iuran',
            'tenggat_iuran',
        )
        ->join('property', 'iurans.id_property', '=', 'property.id_property')
        ->when($filter, function ($query, $search) {
            $query->where('status', 'like', "%{$search}%")
                  ->orWhere('iuran_desc', 'like', "%{$search}%")
                  ->orWhere('type_iuran', 'like', "%{$search}%")
                  ->orWhere('nominal_iuran', 'like', "%{$search}%");
        })->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Iuran",
            "data" => $iuran,
        ], 200);
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
            'nominal_iuran' => ['required', 'numeric', 'min:0'],
            'iuran_desc' => ['required', 'string', 'max:255'],
            'type_iuran' => ['required', 'string', 'max:20'],
            'tenggat_iuran' => ['required', 'date:Y-m-d'],
        ]);

        $iuran = Iuran::findOrFail($id);

        $iuran->update([
            'nominal_iuran' => $request->nominal_iuran,
            'iuran_desc' => $request->iuran_desc,
            'type_iuran' => $request->type_iuran,
            'tanggal_iuran' => $request->tenggat_iuran,
            'tenggat_iuran' => $request->tenggat_iuran,
        ]);

        $iuran->save();

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil mengupdate iuran",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Iuran Updated',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $iuran = Iuran::findOrFail($id);
        $iuran->delete();

        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menghapus iuran",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Iuran Deleted',
            ]);
            return redirect()->back();
        }
    }
}
