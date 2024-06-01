<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PlaceImage extends Model
{
    use CrudTrait;
    protected $table = 'images';
    protected $guarded = ['id'];
    
    use HasFactory;
    protected $fillable = [
        'place_id', 
        'image'];
}
