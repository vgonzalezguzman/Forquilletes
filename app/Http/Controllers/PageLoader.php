<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Restaurant;

class PageLoader extends Controller
{
    public function home(Request $request)
    {
        $restaurants = Restaurant::with('comments')
            ->withCount('comments')
            ->withAvg('comments', 'rating')
            ->get();
        return Inertia::render('Home', [
            'user' => $request->user(),
            'restaurants' => $restaurants,
        ]);
    }

    public function dashboard(Request $request)
    {
        $restaurants = Restaurant::with('comments')
            ->withCount('comments')
            ->withAvg('comments', 'rating')
            ->get();
        return Inertia::render('Dashboard', [
            'user' => $request->user(),
            'restaurants' => $restaurants,
        ]);
    }
}
