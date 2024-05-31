<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

// use Illuminate\Database\Eloquent\Relations\HasMany;

class Place extends Model
{
    // use HasFactory;
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'places';
    protected $guarded = ['id'];

    protected $fillable = [
        'longitude',
        'latitude'
    ];
}
