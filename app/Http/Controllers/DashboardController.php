<?php

namespace App\Http\Controllers;

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
        return [
            'total' => $total,
            'totalLastWeek' => $totalLastWeek,
            'all' => $models
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
                'percent' => ($property['totalLastWeek'] / $property['total']) * 100,
            ],
            'user' => [
                'object' => $user['all'],
                'percent' => ($user['totalLastWeek'] / $user['total']) * 100,
            ],
            'owner' => [
                'object' => $owner['all'],
                'percent' => ($owner['totalLastWeek'] / $owner['total']) * 100,
            ],
            'resident' => [
                'object' => $resident['all'],
                'percent' => ($resident['totalLastWeek'] / $resident['total']) * 100,
            ],
        ]);
    }

}
