<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        $user = new User();
        $data['users_count']    = $user->count();
        $data['users_not_posts'] = $user->whereDoesntHave('posts')->count();
        $data['posts']          = Post::count();

        return successMessageWithData('data', $data);
    }
}
