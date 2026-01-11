<div>
    {{ 'people' }}
    <flux:button icon="plus" href="{{ route('person.show') }}"/>
    <br>
    <br>
    @foreach($people as $person)
        {{ $person->id . ":" . $person->name . ":" .  $person->age }}
        <flux:button
            wire:confirm="Delete OK?"
            wire:click="delete({{ $person->id }})"
        >Delete
        </flux:button>
        <br>
    @endforeach
</div>
