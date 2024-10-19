<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ProjectRecognition extends Model
{
    
    use CrudTrait;

    protected $table = 'project_recognition';
    // protected $primaryKey = 'id';
    
    protected $guarded = ['id'];
    protected $fillable = ['project_id', 'partner_id', 'value'];
}
