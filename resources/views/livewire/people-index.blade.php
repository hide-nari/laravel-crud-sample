<div>
    {{ 'people123' }}
    <flux:button icon="plus" href="{{ route('person.show') }}"/>
    <br>
    <br>
    @foreach($this->people as $person)
        {{ $person->id . ":" . $person->name . ":" .  $person->age }}
        <flux:button href="{{ route('person.show',$person) }}" variant="primary">
            Update
        </flux:button>
        <flux:button wire:confirm="Delete OK?" wire:click="delete({{ $person->id }})" variant="danger">
            Delete
        </flux:button>
        <br>
    @endforeach
</div>
