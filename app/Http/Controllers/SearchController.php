<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Community;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (strlen($query) < 2) {
            return response()->json(['users' => [], 'communities' => []]);
        }

        $users = User::where('id', '!=', auth()->id())
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                  ->orWhere('last_name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$query}%"]);
            })
            ->limit(5)
            ->get(['id', 'first_name', 'last_name', 'email']);

        $communities = Community::with('user')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('subject', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'name', 'subject', 'user_id']);

        return response()->json([
            'users' => $users->map(fn($u) => [
                'id'     => $u->id,
                'name'   => trim("{$u->first_name} {$u->last_name}"),
                'email'  => $u->email,
                'initials' => strtoupper(substr($u->first_name, 0, 1) . substr($u->last_name, 0, 1)),
                'url'    => route('dashboard'), // link to dashboard for now
            ]),
            'communities' => $communities->map(fn($c) => [
                'id'      => $c->id,
                'name'    => $c->name,
                'subject' => $c->subject,
                'url'     => route('community.show', $c->id),
            ]),
        ]);
    }
}
