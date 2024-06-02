<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function index(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        return Inertia::render('Restaurant/Index',
            [
                'user' => $request->user(),
                'restaurant' => $restaurant,
            ]
        );
    }
}
