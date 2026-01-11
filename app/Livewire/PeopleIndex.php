<?php

namespace App\Livewire;

use App\Models\Person;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PeopleIndex extends Component
{

    #[Computed]
    public function people()
    {
        return Person::all();
    }

    public function delete($personId): void
    {
        Person::find($personId)->delete();
        redirect()->route('people.index');
    }

    public function render()
    {
        return view('livewire.people-index');
    }
}
