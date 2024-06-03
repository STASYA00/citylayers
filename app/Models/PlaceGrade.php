<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PlaceGrade extends Model
{
    protected $table = 'place_grades';
    protected $guarded = ['id'];
    use CrudTrait;
    use HasFactory;
    protected $fillable = [
        'place_id', 
        'category_id',
        'grade'];
}
