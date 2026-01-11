<?php

namespace App\Livewire;

use App\Models\Person;
use Livewire\Component;

class PeopleIndex extends Component
{
//    public $people;

    public function delete($personId): void
    {
        Person::find($personId)->delete();
        redirect()->route('people.index');
    }

    public function render()
    {
        return view('livewire.people-index', ['people' => Person::all()]);
    }
}
