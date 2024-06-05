<?php

use App\Models\User;

test('Dashboard page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/dashboard');

    $response->assertOk();
});

test('Restaurant page is displayed', function () {
    $response = $this
        ->get('/restaurant/show/1');

    $response->assertOk();
});

test('Create restaurant page is displayed', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->get('/restaurant/create');

    $response->assertOk();
});