<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('user')->latest()->get();
        return response()->json($blogs, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|array' // Adjust the validation rules as needed
        ]);

        // Assuming you are using authentication and have an authenticated user
        $user = auth()->user();

        $blog = new Blog([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $user->id,
            'view_count' => 0,
            'category' => $request->category, // Initial view count set to 0
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs/images');
            $blog->image = $imagePath;
        }

        $blog->save();

        return response()->json($blog, 201);
    }
    public function getUserBlogs($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $blogs = $user->blogs()->latest()->get();

        return response()->json($blogs, 200);
    }
    public function search(Request $request)
    {
        $request->validate([
            'keywords' => 'required|string',
        ]);

        $keywords = $request->keywords;

        $blogs = Blog::where('title', 'LIKE', '%' . $keywords . '%')
            ->orWhere('content', 'LIKE', '%' . $keywords . '%')
            
            ->get();

        return response()->json($blogs, 200);
    }
}
