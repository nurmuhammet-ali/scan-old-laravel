<?php

// Authentication Routes... 👤
Auth::routes();

// Remove registerable option 👮
Route::match(['get', 'post'], '/register', 'EjenSikeyinController@register')->name('register');

// EjenSikeyinController... ⁉️
Route::get('/', 'EjenSikeyinController@index')->name('home');

Route::get('test', 'EjenSikeyinController@test');

// Tests Results Routes... 💹
Route::get('hostings-test/{hosting}/show', 'EjenSikeyinController@show')->name('hostings_checked.show');

Route::middleware('auth')->group(function () {
    // Admin Routes... 👤
    Route::get('admin', 'AdminController@index')->name('admin');
    
    // Changes Routes... 💱
    Route::get('changes', 'AdminController@changes')->name('changes');

    // Hosting Types Routes... 💸
    Route::get('types', 'TypesController@index')->name('types.index');
    Route::post('types/update', 'TypesController@update')->name('types.update');
    Route::post('types', 'TypesController@store')->name('types.store');
    Route::post('types/destroy', 'TypesController@destroy')->name('types.delete');

    // Hosting Plans Routes... 💳
    Route::get('plans', 'PlansController@index')->name('plans.index');
    Route::post('plans', 'PlansController@store')->name('plans.store');
    Route::post('plans/update', 'PlansController@update')->name('plans.update');
    Route::post('plans/destroy', 'PlansController@destroy')->name('plans.delete');

    // Hostings Routes... 💻
    Route::get('hostings/create', 'HostingsController@create')->name('hostings.create');
    Route::post('hostings', 'HostingsController@store')->name('hostings.store');
    Route::get('hostings/{hosting}/show', 'HostingsController@show')->name('hostings.show');
    Route::get('hostings/{hosting}/edit', 'HostingsController@edit')->name('hostings.edit');
    Route::post('hostings/{hosting}/update', 'HostingsController@update')->name('hostings.update');
    Route::delete('hostings/{hosting}/destroy', 'HostingsController@destroy')->name('hostings.destroy');
});
