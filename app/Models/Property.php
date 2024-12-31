<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Property extends Model
{
    protected $table = 'property';
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_user_owner',
        'property_name',
        'property_desc',
        'property_category',
        'id_cover',
    ];

    protected $primaryKey = 'id_property';
    protected $guarded  = 'id_property';

    public function user()
    {
        return $this->hasOne(User::class, "id_user", "id_user_owner");
    }   

    public function getReview()
    {
        return $this->hasMany(property_comment::class, "id_property", "id_property");
    }

    public function rent()
    {
        return $this->hasMany(Rent::class, "id_property", "id_property");
    }

    public function facility()
    {
        return $this->hasMany(Facility::class, "id_property", "id_property");
    }

    public function iuran() {
        return $this->hasMany(Iuran::class, "id_property", "id_property");
    }

    public function album()
    {
        return $this->hasOne(Album::class, "id_album", "id_cover");
    }

    public function getAlbum()
    {
        return $this->hasMany(Album::class, "id_property", "id_property");
    }

    public function property_address() {
        return $this->hasOne(Property_Address::class, "id_property", "id_property");
    }

    public function getLocation(){
        $getAddress = $this->property_address()->first();
        return $getAddress->street_name . ", " . $getAddress->province . ", " . $getAddress->zipcode . ", " . $getAddress->country;
    }

    public function getLongLat() {
        $getAddress = $this->property_address()->first();
        return [
            'long' => $getAddress->longitude,
            'lat' => $getAddress->latitude
        ];
    }

    public function property_contact() {
        return $this->hasOne(Property_Contact::class, "id_property", "id_property");
    }

    public function getPriceRange() {
        $rent = $this->rent()->where('availability', 1)->get();
        if (count($rent) == 0) {
            return null;
        } else {
            $min = $rent->min('rent_price');
            $max = $rent->max('rent_price');
            return [
                'min' => $min,
                'max' => $max
            ];
        }
    }

    public function getView() {
        return $this->hasMany(property_visited::class, "id_property", "id_property");
    }

    public function getComment() {
        return $this->hasMany(property_comment::class, "id_property", "id_property");
    }
    
    public function getBookings() {
        return $this->hasMany(Booking::class, "id_property", "id_property");
    }

    public function getPrecentageOfBookingLastWeek() {
        $bookings = $this->getBookings()->where('created_at', '>=', now()->subWeek()->subWeek())->where('created_at', '<=', now()->subWeek())->get();
        $total = $this->getBookings()->count();
        $totalLastWeek = $bookings->count();
        if ($totalLastWeek == 0) {
            return 0;
        }
        return ($totalLastWeek / $total) * 100;
    }

    public function getPrecentageOfResidentLastWeek() {
        $residents = $this->getResidents()->where('created_at', '>=', now()->subWeek()->subWeek())->where('created_at', '<=', now()->subWeek())->get();
        $total = $this->getResidents()->count();
        $totalLastWeek = $residents->count();
        if ($totalLastWeek == 0) {
            return 0;
        }
        return ($totalLastWeek / $total) * 100;
    }

    public function getResidents() {
        return $this->hasMany(Resident::class, "id_property", "id_property");
    }
    
    public function getAvgRating() {
        return $this->getComment()->avg('rating');
    }

    public function getFavorite() {
        return $this->hasMany(property_favorited::class, "id_property", "id_property");
    }

    public function getAvailabelityBasedOnRent() {
        $rent = $this->rent()->where('availability', 1)->first();
        if ($rent == null) {
            return false;
        }
        return true;
    }

    public function getTotalAvailable() {
        $rent = $this->rent()->where('availability', 1)->get();
        return $rent->count();
    }

    public function getTotalRentStock() {
        $rent = $this->rent()->get();
        return $rent->sum('stock');
    }

    public function getTotalUnTargetedIuran() {
        $total = 0;
        $iurans = $this->iuran()->get();
        foreach ($iurans as $iuran) {
            if (!$iuran->isLunas()) {
                $total += 1;
            }
        }
        return $total;
    }
}
