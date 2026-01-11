<?php

namespace App\Livewire;

use App\Models\Person;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PersonShow extends Component
{
    #[Validate('required')]
    public string $name = 'taro';
    #[Validate('required')]
    public int $age = 15;

    public function add(): void
    {
        $this->validate();
        Person::create([
            'name' => $this->pull('name'),
            'age'  => $this->pull('age'),
        ]);
        redirect()->route('people.index');
    }

    public function render()
    {
        return view('livewire.person-show');
    }
}
