<?php

namespace App\Http\Livewire;

use App\Models\PlaceDetails;
use App\Models\Place;
use App\Models\Observation;
use App\Models\User;
use DB;
use Livewire\Component;

class Filter extends Component
{
    // public $places;

    public $selected_places = [];
    public $selected_observation;

    public function select_place($id)
    {

        // $this->selected_places['place'] = session('placeIds');
        // $this->selected_places['observation'] = session('observationIds');

       

    

    }

    public function updateMap()
    {

        // session(['placeIds' => array_unique($this->selected_places['place']), 'observationIds' => array_unique($this->selected_places['observation'])]);
        
    }

    public function render()
    {
        $userid = backpack_auth()->user()->id;
        $placeIds = PlaceDetails::where('user_id', $userid)
            ->whereNotNull('place_id')
            ->distinct()
            ->pluck('place_id');
        $observationIds = PlaceDetails::where('user_id', $userid)
            ->whereNotNull('observation_id')
            ->distinct()
            ->pluck('observation_id');
        $places = Place::select('name','id')->whereIn('id', $placeIds)->get();
        $observations = Observation::select('name','id')->whereIn('id', $observationIds)->get();

        $places->each(function ($place) {
            $place->source = 'place';
        });
        
        $observations->each(function ($observation) {
            $observation->source = 'observation';
        });

        $combined = $places->concat($observations);
        $places = $combined->sortBy(function ($item) {
            return $item->name;
        });

        $placeIds = session('placeIds');
        $observationIds = session('observationIds');

        return view('livewire.filter',  ('places','placeIds','observationIds'));
    }
}
