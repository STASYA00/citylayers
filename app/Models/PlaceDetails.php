<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class PlaceDetails extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $fillable = [
        'user_id',
        'place_image',
        'place_description',
        'obsevation_image',
        'obsevation_description',
        'description',
        'latitude',
        'longitude',
    ];


    public function getPlaceString()
    {
        $html='<ul>';
        $html .= '<li>' . (isset($this->placeDetail->place) ? '#'.$this->placeDetail->place->name : 'No place');

        $html .= '<ul><li>'.(isset($this->placeDetail->placeChild?->name) ? '##'.$this->placeDetail->placeChild?->name : '').'</li></ul>';


        $html.='</li></ul>';
        return $html;
    }
    public function getObservationString()
    {
        $observationString=NULL;
        $parent=[];
       
        foreach ($this->observationsDetail as $observation) {

            if(in_array($observation->observation->name,$parent)){
                $observationChildName = $observation->observationChild?$observation->observationChild->name.' ('.$observation->feeling_id.')': '';
                if($observationChildName){
                    $observationString .= '<ul><li>##' . $observationChildName . '</li></ul>'; 
                }
            }else{
                $observationChildName = $observation->observationChild?$observation->observationChild->name.' ('.$observation->feeling_id.')': '';
                $observationString .= '<li>#' . $observation->observation->name;
                
                if($observationChildName){
                    $observationString .= '<ul><li>##' . $observationChildName . '</li></ul>'; 
                }else{
                    $observationString .= '('. $observation->feeling_id .')';
                }
                $parent[]=$observation->observation->name;
            }
            // $observationString .= '<hr>';
        }

        

        if(empty($observationString)){
            $observationString='No Observation';
        }
        $observationString='<ul>'.$observationString.'</ul>';
        
        return $observationString;
    }

    public function placeDetail()
    {
        return $this->hasOne(PlaceDetailPlace::class, 'place_detail_id', 'id');
    }

    public function observationsDetail()
    {
        return $this->hasMany(PlaceDetailObservation::class, 'place_detail_id', 'id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function placeComment()
    {
        return $this->hasOne(PlaceComment::class,'place_detail_id', 'id');
    }
    public function placeComments()
    {
        return $this->hasMany(PlaceComment::class,'place_detail_id', 'id');
    }

    public function placeGrade()
    {
        return $this->hasOne(PlaceGrade::class, 'place_detail_id','id');
    }
    public function placeGrades()
    {
        return $this->hasMany(PlaceGrade::class,'place_detail_id','id');
    }

    public function placeLikes()
    {
        return $this->hasMany(PlaceLike::class,'place_detail_id', 'id');
    }

    public function getListplaceCommentsAttribute()
    {
        return $this->placeComments->pluck('comment')->implode(', ');
    }

    public function getListplaceGradesAttribute()
    {
        return $this->placeGrades->pluck('grade')->implode(', ');
    }

    public function getTotalLikesAttribute()
    {
        return $this->placeLikes->count();
    }
    

    public function updatePlaces($place_detail,$request){
            PlaceDetailPlace::where('place_detail_id', $place_detail->id)->delete();
            if($request->place_id){
                PlaceDetailPlace::create([
                    'place_detail_id' => $place_detail->id,
                    'place_id' => $request->place_id,
                    'place_child_id' => $request->child_place_id?$request->child_place_id:NULL,
                ]);
            }
    }
    public function updateObservations($place_detail,$request){
        PlaceDetailObservation::where('place_detail_id', $place_detail->id)->delete();
        if(isset($request->observations) && is_array($request->observations) && count($request->observations)>0){
            foreach($request->observations as $obsrv){
                PlaceDetailObservation::create([
                    'place_detail_id' => $place_detail->id,
                    'observation_id' => $obsrv['observation_id'],
                    'observation_child_id' => $obsrv['child_observation_id']?$obsrv['child_observation_id']:NULL,
                    'feeling_id' => $obsrv['feeling_id'],
                ]);
            }
        }
    }
    public function updateMethod($place_detail,$request){
        $this->updatePlaces($place_detail,$request);
        $this->updateObservations($place_detail,$request);
    }

}
