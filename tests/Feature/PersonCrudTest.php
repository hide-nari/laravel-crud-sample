<?php


use App\Models\Person;
use App\Models\User;

test('people list view test', function () {
    $this->actingAs(User::factory()->create());

    Person::create([
        'name' => 'taro',
        'age'  => 15,
    ]);

    $this->actingAs(User::factory()->create());

    $page = visit('/people');

    $page->assertSee('people');
    $page->assertSee('taro');
    $page->assertSee('15');

});

test('person create test', function () {
    $inputName = "taro";
    $inputAge = "15";

    $this->actingAs(User::factory()->create());

    $page = visit('/person');
    $page->fill('name', $inputName)
        ->fill('age', $inputAge)
        ->click('Add');

    $page->assertSee('people');
    $page->assertSee($inputName);
    $page->assertSee($inputAge);
});

test('person update pattern', function () {
    $this->actingAs(User::factory()->create());

    Person::create([
        'name' => 'taro',
        'age'  => 15,
    ]);

    $page = visit('/person/1');

    $page->fill('name', 'jiro')
        ->fill('age', '20')
        ->click('Update');

    $page->assertSee('people');
    $page->assertSee('jiro');
    $page->assertSee('20');
});

test('person delete pattern', function () {
    $this->actingAs(User::factory()->create());

    Person::create([
        'name' => 'taro',
        'age'  => 15,
    ]);

    $page = visit('/people');

    $page->click('Update');

    // TODO confirm form

    $page->assertSee('people');
});
