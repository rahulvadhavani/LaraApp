<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Models\Post;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = 'Posts';
        $posts = Post::with('user')->orderBy('id', 'desc')->paginate(10);
        return view('admin.post.index', compact('posts', 'module'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $module = 'Post Create';
        return view('admin.post.create', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        unset($data['id']);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(Post::UPLOAD_PATH);
            $data['image'] = basename($imagePath);
        } else {
            unset($data['image']);
        }
        Post::create($data);
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $module = 'Post Detail';
        return view('admin.post.show', compact('post', 'module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $module = 'Post Edit';
        return view('admin.post.edit', compact('post', 'module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCreateRequest $request, Post $post)
    {
        $data = $request->validated();
        unset($data['id']);
        if ($request->password == null) {
            unset($data['password']);
        }
        if ($request->hasFile('image')) {
            $image = $post->getAttributes()['image'] ?? null;
            $imagePath = $request->file('image')->store(Post::UPLOAD_PATH);
            $file_path =  storage_path(Post::STORAGE_PATH . $image);
            if ($image != null && file_exists($file_path)) {
                unlink($file_path);
            }
            $data['image'] = basename($imagePath);
        }

        $post->update($data);
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $image = $post->getAttributes()['image'] ?? null;
        $file_path =  storage_path(Post::STORAGE_PATH . $image);
        $post->delete();
        if ($image != null && file_exists($file_path)) {
            unlink($file_path);
        }
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully');
    }
}
