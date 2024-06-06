<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plat;
use App\Models\PlatType;
use GuzzleHttp\Psr7\Response;
use Inertia\Inertia;

class PlatController extends Controller
{
    public function create(Request $request)
    {
        try {
            $rId = $request->input('rId');
            $type = $request->input('type');
            $name = $request->input('title');
            $price = $request->input('price');

            $tId = PlatType::where('type', $type)->pluck('id')->first();

            $plat = new Plat;
            $plat->rId = $rId;
            $plat->name = $name;
            $plat->price = $price;
            $plat->tId = $tId;
            $plat->save();
            return Response()->json([200, 'Plat creat correctament']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $platId = $request->input('pId');
            $type = $request->input('type');
            $name = $request->input('title');
            $price = $request->input('price');

            $tId = PlatType::where('type', $type)->pluck('id')->first();

            $plat = Plat::find($platId);
            $plat->name = $name;
            $plat->price = $price;
            $plat->tId = $tId;
            $plat->save();
            return Response()->json([200, 'Plat creat correctament']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->input('pId');
            $plat = Plat::find($id);
            $plat->delete();
            return Response()->json([200, 'Plat creat correctament']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
