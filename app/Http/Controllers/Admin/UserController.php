<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = 'Users';
        $users = User::userRole()->orderBy('id', 'desc')->paginate(5);
        return view('admin.user.index', compact('users', 'module'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $module = 'User Create';
        return view('admin.user.create', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->validated();
        unset($data['id']);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(User::UPLOAD_PATH);
            $data['image'] = basename($imagePath);
        } else {
            unset($data['image']);
        }
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $module = 'User Detail';
        return view('admin.user.show', compact('user', 'module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $module = 'User Edit';
        return view('admin.user.edit', compact('user', 'module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserCreateRequest $request, User $user)
    {
        $data = $request->validated();
        unset($data['id']);
        if($request->password == null){
            unset($data['password']);
        }else{
            $data['password'] = Hash::make($data['password']);
        }
        if ($request->hasFile('image')) {
            $image = $user->getAttributes()['image'] ?? null;
            $imagePath = $request->file('image')->store(User::UPLOAD_PATH);
            $file_path =  storage_path(User::STORAGE_PATH . $image);
            if ($image != null && file_exists($file_path)) {
                unlink($file_path);
            }
            $data['image'] = basename($imagePath);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $image = $user->getAttributes()['image'] ?? null;
        $file_path =  storage_path(User::STORAGE_PATH . $image);
        $user->delete();
        if ($image != null && file_exists($file_path)) {
            unlink($file_path);
        }
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
