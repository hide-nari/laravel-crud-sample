<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Volt::route('people', 'people-index')
    ->middleware(['auth', 'verified'])
    ->name("people.index");

Volt::route('person/{person?}', 'person-show')
    ->middleware(['auth', 'verified'])
    ->name("person.show");

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
