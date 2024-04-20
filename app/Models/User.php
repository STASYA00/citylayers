<?php

namespace App\Models;

//  use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{

    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'score'
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasPermissionTo()
    {
        return 'notifications admin';
    }
    public function placeDetails()
    {
        return $this->hasMany(PlaceDetails::class, 'user_id');
    }
    public function getTotalPlacesMappedAttribute()
    {
        $total = 0;
        foreach ($this->placeDetails as $placeDetail) {
            $total += $placeDetail->placeDetail()->count();
        }
        return $total;
    }
    public function getTotalObservationMappedAttribute()
    {
       
        $allobservation = $this->placeDetails->flatMap(function ($placeDetail) {
            return $placeDetail->observationsDetail->map(function ($observation) {
                return $observation->only(['place_detail_id', 'observation_id']);
            });
        })->unique();
        return $allobservation->count();


    }

    public function places()
    {
        return $this->hasMany(Place::class, 'user_id');
    }
   
    public function observations()
    {
        return $this->hasMany(Observation::class, 'user_id');
    }


    public function observationImages() {
        return $this->hasManyThrough(ObservationImage::class, PlaceDetails::class);
    }
    
    public function placeImages() {
        return $this->hasManyThrough(PlaceImage::class, PlaceDetails::class);
    }

    public function incrementScore($number)
    {
        $this->score = $this->score + $number;
        $this->save();
    }


    public function infosperso()
    {
        return $this->hasOne(Infosperso::class);
    }
    public function getpreferencesAttribute()
    {
        if ($this->infosperso) {
            $preferencesArray = json_decode($this->infosperso->preferences, true);
            if (is_array($preferencesArray)) {
                $preferencesString = implode(', ', $preferencesArray);
            } else {
                $preferencesString = '';
            }
            return $preferencesString;
        }
        return '';
    }

    public function likedPlaces()
    {
        return $this->hasMany(PlaceLike::class, 'user_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(PlaceComment::class, 'user_id', 'id');
    }

    public function grades()
    {
        return $this->hasMany(PlaceGrade::class, 'user_id', 'id');
    }



}
