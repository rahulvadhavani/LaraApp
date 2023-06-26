<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = 'Categories';
        $categories = Category::orderBy('id', 'desc')->paginate(5);
        return view('category.index', compact('categories', 'module'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $module = 'Category Create';
        return view('category.create', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(Category::UPLOAD_PATH);
            $data['image'] = basename($imagePath);
        } else {
            unset($data['image']);
        }
        Category::create($data);
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $module = 'Category Detail';
        return view('category.show', compact('category', 'module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $module = 'Category Edit';
        return view('category.edit', compact('category', 'module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryCreateRequest $request, Category $category)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $image = $category->getAttributes()['image'] ?? null;
            $imagePath = $request->file('image')->store(Category::UPLOAD_PATH);
            $file_path =  storage_path(Category::STORAGE_PATH . $image);
            if ($image != null && file_exists($file_path)) {
                unlink($file_path);
            }
            $data['image'] = basename($imagePath);
        }

        $category->update($data);
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $image = $category->getAttributes()['image'] ?? null;
        $file_path =  storage_path(Category::STORAGE_PATH . $image);
        $category->delete();
        if ($image != null && file_exists($file_path)) {
            unlink($file_path);
        }
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
