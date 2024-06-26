<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Restaurant;
use App\Models\RestaurantImage;
use App\Models\User;
use App\Models\Comment;
use App\Models\CommentImage;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function index(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        $gallery = RestaurantImage::where('rId', $id)->get();
        $owner = User::where('id', $restaurant->owner ?? null)->first();
        $comments = Comment::with([
            'user' => function ($query) {
                $query->select('id', 'name', 'email', 'avatar');
            },
            'commentImages'
        ])->where('rId', $id)->get(['id', 'rId', 'uId', 'title', 'description', 'rating']);
        $comments = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'restaurant_id' => $comment->rId,
                'created' => $comment->created_at,
                'updated' => $comment->updated_at,
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'email' => $comment->user->email,
                    'avatar' => $comment->user->avatar,
                ],
                'title' => $comment->title,
                'description' => $comment->description,
                'rating' => $comment->rating,
                'images' => $comment->commentImages->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'url' => $image->url
                    ];
                })->toArray(),
            ];
        });

        return Inertia::render(
            'Restaurant/Index',
            [
                'user' => $request->user(),
                'restaurant' => $restaurant,
                'gallery' => $gallery,
                'owner' => $owner,
                'comments' => $comments
            ]
        );
    }

    public function uploadComment(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'rating' => 'required|integer',
                'restaurant_id' => 'required|integer',
            ]);

            $uId = $request->user()->id;
            $rId = $request->input('restaurant_id');
            $title = $request->input('title');
            $description = $request->input('description');
            $rating = $request->input('rating');

            $comment = new Comment();
            $comment->rId = $rId;
            $comment->uId = $uId;
            $comment->title = $title;
            $comment->description = $description;
            $comment->rating = $rating;
            $comment->save();

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $galleryImage) {
                    $galleryPath = $galleryImage->store('images', 'public');
                    CommentImage::create([
                        'cId' => $comment->id,
                        'url' => $galleryPath,
                    ]);
                }
            }

            return response()->json(['message' => 'Comment added successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save comment'], 500);
        }
    }

    public function updateComment(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'rating' => 'required|integer',
                'cId' => 'required|integer',
            ]);

            $cId = $request->input('cId');
            $title = $request->input('title');
            $description = $request->input('description');
            $rating = $request->input('rating');

            $comment = Comment::find($cId);
            $comment->title = $title;
            $comment->description = $description;
            $comment->rating = $rating;
            $comment->save();

            if ($request->hasFile('galleryToUpload')) {
                foreach ($request->file('galleryToUpload') as $galleryImage) {
                    $galleryPath = $galleryImage->store('images', 'public');
                    CommentImage::create([
                        'cId' => $comment->id,
                        'url' => $galleryPath,
                    ]);
                }
            }

            if ($request->input('imageToDelete')) {
                foreach ($request->input('imageToDelete') as $imagetoDelete) {
                    $image = CommentImage::find($imagetoDelete);
                    Storage::disk('public')->delete($image->url);
                    $image->delete();
                }
            }

            return response()->json(200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete comment'], 500);
        }
    }

    public function deleteComment(Request $request)
    {
        try {
            $commentId = $request->input('commentId');
            $comment = Comment::find($commentId);
            $images = CommentImage::where('cId', $commentId)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }
            $comment->delete();
            return response()->json([$comment]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete comment'], 500);
        }
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
            if ($request->user()->id == $request->input('uploader') || $request->user()->id == $request->input('owner')) {
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
            } else {
                return response()->json(['error' => 'You are not authorized to update this restaurant'], 403);
            }
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
            if ($email) {
                $restaurant->email = $email;
            }
            if ($phone) {
                $restaurant->phone = $phone;
            }
            if ($website) {
                $restaurant->website = $website;
            }
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
    public function delete(Request $request)
    {
        try {
            if ($request->user()->id == $request->input('uploader') || $request->user()->id == $request->input('owner')) {
                $id = $request->input('restaurant');
                $restaurant = Restaurant::find($id);
                $gallery = RestaurantImage::where('rId', $id)->get();
                $comments = Comment::where('rId', $id)->get();
                foreach ($comments as $comment) {
                    $images = CommentImage::where('cId', $comment->id)->get();
                    foreach ($images as $image) {
                        Storage::disk('public')->delete($image->url);
                        $image->delete();
                    }
                    $comment->delete();
                }
                foreach ($gallery as $image) {
                    Storage::disk('public')->delete($image->url);
                    $image->delete();
                }
                Storage::disk('public')->delete($restaurant->avatar);
                $restaurant->delete();
                return response()->json(['message' => 'Restaurant deleted successfully']);
            } else {
                return response()->json(['error' => 'You are not authorized to delete this restaurant'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function renderMap(Request $request)
    {
        $restaurants = Restaurant::with('comments')
            ->withCount('comments')
            ->withAvg('comments', 'rating')
            ->get();
        return Inertia::render('Map', [
            'user' => $request->user(),
            'restaurants' => $restaurants
        ]);
    }
}
