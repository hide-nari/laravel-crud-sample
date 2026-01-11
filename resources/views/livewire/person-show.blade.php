<div>
    <flux:input wire:model="name" label="Name:"></flux:input>
    <br>
    <flux:input wire:model="age" label="Age:" type="number"></flux:input>
    <br>
    <flux:button
        wire:click="add"
        variant="primary"
        class="mr-2"
    >Add
    </flux:button>
    <br>
    <br>
    <flux:button href="{{ route('people.index') }}" variant="filled">Back</flux:button>
</div>
