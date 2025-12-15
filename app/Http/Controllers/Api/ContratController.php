<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Contrat::all();
        return ContratResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $slug = Str::slug($request->title);
        $validated['slug'] = $slug;
        Contrat::create($validated);
        return response()->json(['message' => 'Post created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Contrat::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);
        $post = Post::findOrFail($id);
        if ($request->has('title')) {
            $post->slug = Str::slug($request->title);
        }
        $post->update($validated);
        return response()->json(['message' => 'Post updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::findOrFail($id)->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
