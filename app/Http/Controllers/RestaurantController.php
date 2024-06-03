<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Restaurant;
use App\Models\RestaurantContact;
use App\Models\RestaurantImage;

class RestaurantController extends Controller
{
    public function index(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        return Inertia::render(
            'Restaurant/Index',
            [
                'user' => $request->user(),
                'restaurant' => $restaurant,
            ]
        );
    }

    public function editRestaurant(Request $request, $id) {
        $restaurant = Restaurant::find($id);
        $gallery = RestaurantImage::where('rId', $id)->get();
        $contacts = RestaurantContact::where('rId', $id)->get();
        return Inertia::render(
            'Restaurant/Edit',
            [
                'user' => $request->user(),
                'restaurant' => $restaurant,
                'gallery' => $gallery,
                'contacts' => $contacts,
            ]
        );
    }

    public function renderCreate(Request $request)
    {
        $contacts = Contact::all();
        return Inertia::render(
            'Restaurant/Create',
            [
                'user' => $request->user(),
                'contacts' => $contacts,
            ]
        );
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'eventImg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $description = $request->input('description');
            $address = $request->input('address');
            $lat = $request->input('lat');
            $lng = $request->input('lng');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $website = $request->input('website');

            $file = $request->file('eventImg');
            $path = null;

            if ($file) {
                $path = $file->store('images', 'public');
            }

            $restaurant = new Restaurant();
            $restaurant->name = $request->input('name');
            $restaurant->description = $description;
            $restaurant->address = $address;
            $restaurant->uploader = $request->user()->id;
            $restaurant->avatar = $path;
            $restaurant->lat = $lat;
            $restaurant->lng = $lng;
            $restaurant->save();

            $phoneType = Contact::where('type', 'phone')->first();
            $emailType = Contact::where('type', 'email')->first();
            $websiteType = Contact::where('type', 'webpage')->first();

            if ($phone && $phoneType) {
                RestaurantContact::create([
                    'rId' => $restaurant->id,
                    'cId' => $phoneType->id,
                    'url' => $phone
                ]);
            }

            if ($email && $emailType) {
                RestaurantContact::create([
                    'rId' => $restaurant->id,
                    'cId' => $emailType->id,
                    'url' => $email
                ]);
            }

            if ($website && $websiteType) {
                RestaurantContact::create([
                    'rId' => $restaurant->id,
                    'cId' => $websiteType->id,
                    'url' => $website
                ]);
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $galleryImage) {
                    $galleryPath = $galleryImage->store('images', 'public');
                    RestaurantImage::create([
                        'rId' => $restaurant->id,
                        'url' => $galleryPath,
                    ]);
                }
            }

            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
