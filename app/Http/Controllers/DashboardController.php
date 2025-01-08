<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DashboardController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:dashboard-list', ['only' => ['index','show']]);
    }

    public function getPercentage($model, $extendFunction = null) {
        $models = $model::query();
        if ($extendFunction) { $models = $extendFunction($models); }
        $getPercentage = $model::where('created_at', '>=', now()->subWeek()->subWeek())->where('created_at', '<=', now()->subWeek())->get();
        $total = $models->count();
        $totalLastWeek = $getPercentage->count();

        if ($totalLastWeek == 0) {
            $percent = 0;
        } else {
            $percent = ($totalLastWeek / $total) * 100;
        }

        return [
            'total' => $total,
            'totalLastWeek' => $totalLastWeek,
            'all' => $models,
            'percent' => $percent
        ];
    }

    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        // Get Property Card
        $property = $this->getPercentage(Property::class);
        $user = $this->getPercentage(User::class);
        $facility = $this->getPercentage(Facility::class);
        $transaction = $this->getPercentage(Order::class);
        $booking = $this->getPercentage(Booking::class);
        $owner = $this->getPercentage(User::class, function($models) {
            return $models->whereHas('roles', function ($query) {
                $query->where('name', 'Owner');
            });
        });
        $resident = $this->getPercentage(User::class, function($models) {
            return $models->whereHas('roles', function ($query) {
                $query->where('name', 'Resident');
            });
        });

        return view('view.dashboard', [
            'property' => [
                'object' => $property['all'],
                'percent' => $property['percent'],
            ],
            'user' => [
                'object' => $user['all'],
                'percent' => $user['percent'],
            ],
            'owner' => [
                'object' => $owner['all'],
                'percent' => $owner['percent']
            ],
            'resident' => [
                'object' => $resident['all'],
                'percent' => $resident['percent'],
            ],
            'facility' => [
                'object' => $facility['all'],
                'percent' => $facility['percent'],
            ],
            'transaction' => [
                'object' => $transaction['all'],
                'percent' => $transaction['percent'],
            ],
            'booking' => [
                'object' => $booking['all'],
                'percent' => $booking['percent'],
            ],
        ]);
    }

}
