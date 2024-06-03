<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Restaurant;
use App\Models\RestaurantImage;
use Illuminate\Support\Facades\Storage;

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

    public function renderEdit(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        $gallery = RestaurantImage::where('rId', $id)->get();
        return Inertia::render(
            'Restaurant/Edit',
            [
                'user' => $request->user(),
                'restaurant' => $restaurant,
                'gallery' => $gallery
            ]
        );
    }

    public function update(Request $request)
    {
        try {
            $oldId = $request->input('oldId');
            $oldAvatar = $request->input('oldAvatar');
            $name = $request->input('name');
            $description = $request->input('description');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $website = $request->input('website');
            $address = $request->input('address');
            $lat = $request->input('lat');
            $lng = $request->input('lng');

            $file = $request->file('eventImg');
            $path = null;

            if ($file) {
                $path = $file->store('images', 'public');
                Storage::disk('public')->delete($oldAvatar);
            }

            $restaurant = Restaurant::find($oldId);
            if ($name) {
                $restaurant->name = $name;
            }
            if ($description) {
                $restaurant->description = $description;
            }
            if ($email) {
                $restaurant->email = $email;
            }
            if ($phone) {
                $restaurant->phone = $phone;
            }
            if ($website) {
                $restaurant->website = $website;
            }
            if ($address) {
                $restaurant->address = $address;
                $restaurant->lat = $lat;
                $restaurant->lng = $lng;
            }
            if ($path) {
                $restaurant->avatar = $path;
            }
            $restaurant->save();

            if ($request->hasFile('galleryToUpload')) {
                foreach ($request->file('galleryToUpload') as $galleryImage) {
                    $galleryPath = $galleryImage->store('images', 'public');
                    RestaurantImage::create([
                        'rId' => $oldId,
                        'url' => $galleryPath,
                    ]);
                }
            }

            if ($request->input('imageToDelete')) {
                foreach ($request->input('imageToDelete') as $imagetoDelete) {
                    $image = RestaurantImage::find($imagetoDelete);
                    Storage::disk('public')->delete($image->url);
                    $image->delete();
                }
            }

            return response()->json(['message' => 'Restaurant updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function renderCreate(Request $request)
    {
        return Inertia::render(
            'Restaurant/Create',
            [
                'user' => $request->user(),
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
            $restaurant->email = $email;
            $restaurant->phone = $phone;
            $restaurant->website = $website;
            $restaurant->avatar = $path;
            $restaurant->lat = $lat;
            $restaurant->lng = $lng;
            $restaurant->save();

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
