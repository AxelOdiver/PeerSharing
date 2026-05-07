<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $targetUserId = (int) $request->user_id;

        if (Auth::id() === $targetUserId) {
            return response()->json(['message' => 'You cannot like yourself.'], 422);
        }

        $status = Auth::user()->likes()->toggle($targetUserId);

        $liked = count($status['attached']) > 0;

        $likeCount = User::findOrFail($targetUserId)->likedBy()->count();

        return response()->json([
            'action' => $liked ? 'liked' : 'unliked',
            'like_count' => $likeCount,
        ]);
    }
}
