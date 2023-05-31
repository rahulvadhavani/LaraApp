<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = 'Posts';
        $posts = Post::with('user')->where('user_id',auth()->user()->id)->orderBy('id', 'desc')->paginate(5);
        return view('post.index', compact('posts', 'module'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        $module = 'Post Create';
        return view('post.create', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $this->authorize('create', Post::class);
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
        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        $module = 'Post Detail';
        return view('post.show', compact('post', 'module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $module = 'Post Edit';
        return view('post.edit', compact('post', 'module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCreateRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validated();
        unset($data['id']);
        if($request->password == null){
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
        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $image = $post->getAttributes()['image'] ?? null;
        $file_path =  storage_path(Post::STORAGE_PATH . $image);
        $post->delete();
        if ($image != null && file_exists($file_path)) {
            unlink($file_path);
        }
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully');
    }
}