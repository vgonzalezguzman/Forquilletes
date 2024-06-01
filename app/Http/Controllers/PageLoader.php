<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Restaurant;

class PageLoader extends Controller
{
    public function home(Request $request)
    {
        return Inertia::render('Home', [
            'user' => $request->user(),
        ]);
    }

    public function dashboard(Request $request)
    {
        $restaurants = Restaurant::all();
        return Inertia::render('Dashboard', [
            'user' => $request->user(),
            'restaurants' => $restaurants,
        ]);
    }
}
