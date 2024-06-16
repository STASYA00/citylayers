<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class PlaceSubgrade extends Model
{
    protected $table = 'place_subgrades';
    protected $guarded = ['id'];
    use CrudTrait;
    use HasFactory;
    protected $fillable = [
        'grade_id', 
        'category_id',
        'subcategory_id'];
}
