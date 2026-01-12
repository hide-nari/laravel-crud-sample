<?php

use App\Models\Person;
use App\Models\User;

// run command before your test
// ./vendor/bin/pest --update-snapshots
test('person create view snapshot test', function () {
    $this->actingAs(User::factory()->create([
        'name'  => 'taro',
        'email' => 'taro@test.com',
    ]));
    $response = $this->get(route('person.show'));
    expect($response->content())->toMatchSnapshot();
});

test('person update view snapshot test', function () {
    $this->actingAs(User::factory()->create([
        'name'  => 'taro',
        'email' => 'taro@test.com',
    ]));

    $person = Person::create([
        'name' => 'taro',
        'age'  => 15,
    ]);

    $response = $this->get(route('person.show', $person));
    expect($response->content())->toMatchSnapshot();
});
