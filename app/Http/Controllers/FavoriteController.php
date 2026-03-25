<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $itemId = $request->item_id;

        // Toggles the favorite status in the pivot table
        $status = $user->favorites()->toggle($itemId);

        return response()->json([
            'status' => 'success',
            'action' => count($status['attached']) > 0 ? 'swapped' : 'removed'
        ]);
    }

    public function index()
    {
        // Fetches the user's favorites to display on the page
        $favorites = Auth::user()->favorites;
        return view('favorites', compact('favorites'));
    }
}
