<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'social_id',
        'social_type',
        'social_avatar',
        'isVerified'
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }

    protected $primaryKey = 'id_user';
    protected $guarded  = 'id_user';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function contactInformation()
    {
        return $this->hasOne(ContactInformation::class, "id_user");
    }

    public function getAvatarUrl() {
        return $this->contactInformation->profilePath == null ? $this->social_avatar : asset('storage/' .  $this->contactInformation->profilePath);
    }
    public function getFullName() {
        return $this->contactInformation->first_name . ' ' . $this->contactInformation->last_name;
    }
    public function getProperty() {
        return $this->hasMany(Property::class, "id_user_owner", "id_user");
    }
    public function getFollowers() {
        return $this->hasMany(followers::class, "id_user_followed", "id_user");
    }
    public function getFollowings() {
        return $this->hasMany(followers::class, "id_user", "id_user");
    }
    public function getAvgRatings() {
        $avgRatings = 0;
        foreach ($this->getProperty as $property) {
            $avgRatings += $property->getAvgRating();
        }
        return $avgRatings % 5;
    }
    public function getTotalComment() {
        $totalComment = 0;
        foreach ($this->getProperty as $property) {
            $totalComment += $property->getComment->count();
        }
        return $totalComment;
    }

}
