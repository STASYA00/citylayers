<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PlaceComment extends Model
{
    
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'place_comments';
    protected $guarded = ['id'];

    protected $fillable = ['place_detail_id', 'user_id','comment'];
}
