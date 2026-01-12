<?php

namespace App\Livewire;

use App\Models\Person;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PersonShow extends Component
{
    public Person $person;
    public ?int $id = null;
    #[Validate('required')]
    public ?string $name;
    #[Validate('required')]
    public ?int $age;
    public ?string $method = 'update';

    public function mount(Person $person): void
    {
        $person->id ? $this->id = $person->id : $this->method = 'add';
        $this->name = $person->name;
        $this->age = $person->age;
    }

    public function add(): void
    {
        $this->validate();
        Person::create([
            'name' => $this->pull('name'),
            'age'  => $this->pull('age'),
        ]);
        redirect()->route('people.index');
    }

    public function update(): void
    {
        $this->validate();
        Person::find($this->id)->update([
            'name' => $this->name,
            'age'  => $this->age,
        ]);
        redirect()->route('people.index');
    }

    public function render(): View
    {
        return view('livewire.person-show');
    }
}
