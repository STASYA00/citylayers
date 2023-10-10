<?php

namespace App\Http\Livewire;

use App\Models\PlaceDetails;
use App\Models\User;
use Livewire\Component;

class Filter extends Component
{
    // public $places;

    public $selected_places = [];

    public function select_place($id)
    {
        array_push($this->selected_places, $id);
    }

    public function updateMap()
    {

        foreach ($this->selected_places as $value) {

            $data =  PlaceDetails::where('id', $value)->first();

            // dd($data);

            if ($data->is_home == 1) {
                PlaceDetails::where('id', $value)->update([
                    'is_home' => 0
                ]);
            }
            if ($data->is_home == 0) {
                PlaceDetails::where('id', $value)->update([
                    'is_home' => 1
                ]);
            }
        }

        $this->emit('success', 'Map updated successfully');
    }

    public function render()
    {
        $userid = backpack_auth()->user()->id;
        // $places = PlaceDetails::find($userid)->get();
         
        $places = PlaceDetails::where('user_id', $userid)
    ->select('place_id', 'observation_id')
    ->distinct()
    ->orderBy('id', 'desc')
    ->get();



        return view('livewire.filter', compact('places'));
    }
}
