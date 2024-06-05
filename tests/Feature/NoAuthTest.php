<?php

test('Home page is displayed', function () {
    $response = $this
        ->get('/');

    $response->assertOk();
});

test('Map page is displayed', function () {
    $response = $this
        ->get('/map');

    $response->assertOk();
});

test('Login page is displayed', function () {
    $response = $this
        ->get('/login');

    $response->assertOk();
});

test('Register page is displayed', function () {
    $response = $this
        ->get('/register');

    $response->assertOk();
});