<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $limit = 4;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $filtering = $request->filter;

        $getProperty = Property::select(
            'property.property_name', 
            'property.id_cover', 
            'property.id_property', 
            'property_tag', 
            'property_category', 
            'id_user_owner',
            DB::raw('(min(rent_price)) as min_price'),
            'albums.imagePath as cover',
            DB::raw('CONCAT(property_address.street_name, ", ", property_address.province, ", ", property_address.zipcode, ", ", property_address.country) as location'),
            'longitude',
            'latitude',
            DB::raw('COUNT(rents.id_rent) as total_rent'),
            DB::raw('COUNT(property_visiteds.id_property_visited) as total_visit'),
            DB::raw('COUNT(property_favoriteds.id_property_favorited) as total_fav'),
            DB::raw('COUNT(property_comments.id_property_commented) as total_comment'),
            DB::raw('COALESCE(AVG(property_comments.rating), 0) as rating')
        )
        ->join('rents', 'property.id_property', '=', 'rents.id_property')
        ->join('albums', 'property.id_cover', '=', 'albums.id_album')
        ->join('property_address', 'property.id_property', '=', 'property_address.id_property')
        ->leftJoin('property_visiteds', 'property.id_property', '=', 'property_visiteds.id_property')
        ->leftJoin('property_favoriteds', 'property.id_property', '=', 'property_favoriteds.id_property')
        ->leftJoin('property_comments', 'property.id_property', '=', 'property_comments.id_property')
        ->when($filter, function ($query, $search) {
            $query->where('property_name', 'like', "%{$search}%");
        })
        ->when($filtering['filter_type'] ?? null, function ($query, $filterType) {
            $query->whereIn('property_category', $filterType);
        })
        ->when($filtering['filter_price'] ?? null, function ($query, $filterPrice) {
            $conditions = [];
            $bindings = [];
            
            foreach ($filterPrice as $priceRange) {
                [$minPrice, $maxPrice] = explode('~', str_replace('.', '', $priceRange));
                $conditions[] = '(min(rent_price) BETWEEN ? AND ?)';
                $bindings[] = (int)$minPrice;
                $bindings[] = (int)$maxPrice;
            }
            
            if (!empty($conditions)) {
                $query->havingRaw(implode(' OR ', $conditions), $bindings);
            }
        })
        ->when($filtering['filter_facility'] ?? null, function ($query, $filterFacility) {
            $query->whereHas('rent', function ($query) use ($filterFacility) {
                $query->whereHas('getRentFacility', function ($query1) use ($filterFacility) {
                    $query1->whereHas('facility', function ($q) use ($filterFacility) {
                        $q->whereIn('facility_name', $filterFacility);
                    });
                });
            });
        })
        ->groupBy('property.id_property')
        ->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc');
        })
        ->paginate($limit, ['*'], 'page', $page);
        return view('view.home', [
            "property" => $getProperty
        ]);
    }

}
