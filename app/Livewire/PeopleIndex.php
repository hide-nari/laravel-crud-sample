<?php

namespace App\Livewire;

use App\Models\Person;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PeopleIndex extends Component
{

    #[Computed]
    public function people(): Collection
    {
        return Person::all();
    }

    public function delete(int $personId): void
    {
        Person::find($personId)->delete();
        redirect()->route('people.index');
    }

    public function render(): View
    {
        return view('livewire.people-index');
    }
}
