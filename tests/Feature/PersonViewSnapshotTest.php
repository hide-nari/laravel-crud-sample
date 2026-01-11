<?php

use App\Models\User;

// run command before your test
// ./vendor/bin/pest --update-snapshots
test('person create view snapshot test', function () {
    $this->actingAs(User::factory()->create([
        'name' => 'taro',
        'email' => 'taro@test.com',
    ]));
    $response = $this->get(route('person.show'));
    expect($response->content())->toMatchSnapshot();
});
