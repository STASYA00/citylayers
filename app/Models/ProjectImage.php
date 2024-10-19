<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    
    use CrudTrait;

    protected $table = 'project_images';
    // protected $primaryKey = 'id';
    
    protected $guarded = ['id'];
    protected $fillable = ['project_id', 'image', 'caption'];
}
