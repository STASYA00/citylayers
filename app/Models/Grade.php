<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Grade extends Model
{
    
    use CrudTrait;

    protected $table = 'grades';
    protected $guarded = ['id']; 

    protected $fillable = [
        'category_id',
        'grade',
        'placeid',
        'user_id',
        // 'lat',
        // 'lon',
        // 'category_id',
        // 'value',
        // 'user_id',
        // 'created_at',
        // 'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function subobservs(): HasMany
    // {
    //     return $this->hasMany(Observation::class, 'parent_id');
    // }

}
