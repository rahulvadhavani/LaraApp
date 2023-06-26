<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    /**
     * Render index page
     * And laod datatable by ajax
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $baseurl = url('users');
            $data = User::userRole();
            if ($request->order == null) {
                $data->orderBy('created_at', 'desc');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) use ($baseurl) {
                    $url = "<div class='actions-a'>
                <a class='btn-circle btn btn-dark btn-sm module_view_record' data-id='" . $row->id . "' data-url='" . $baseurl . "' title='View'><i class='text-info fas fa-eye'></i></a>
                <a class='btn-circle btn btn-dark btn-sm module_edit_record' data-id='" . $row->id . "' data-url='" . $baseurl . "' title='Edit'><i class='text-warning far fa-edit'></i></a>
                <a class='btn-circle btn btn-dark btn-sm module_delete_record' data-id='" . $row->id . "' data-url='" . $baseurl . "' title='Delete'><i class='text-danger far fa-trash-alt'></i></a>
                </div>";
                    return $url;
                })

                ->addColumn('image', function ($row) {
                    $image = '<img src="' . $row->image . '" class="img-fluid img-radius" width="40px" height="40px">';
                    return $image;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }
        $title =  'Users';
        return view('users.index', compact('title'));
    }

    /**
     * Store or Update user based on id
     * id > 0 Then Update
     * id = 0 Store  
     */
    public function store(UserRequest $request)
    {
        try {
            $postData = $request->only('first_name', 'last_name', 'name', 'image', 'password', 'id', 'email');
            $user = User::where('id', $postData['id'])->first();
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store(User::UPLOAD_PATH);
                $postData['image'] = basename($imagePath);
            } else {
                unset($postData['image']);
            }
            if ($request->password == null) {
                unset($postData['password']);
            }
            if ($request->id == 0) {
                $postData['email_verified_at'] = date('Y-m-d H:i:s');
            }
            if ($user == null) {
                unset($postData['id']);
                User::create($postData);
            } else {
                if ($request->hasFile('image')) {
                    $image = $user->getAttributes()['image'] ?? null;
                    $imagePath = $request->file('image')->store(User::UPLOAD_PATH);
                    $file_path =  storage_path(User::STORAGE_PATH . $image);
                    if ($image != null && file_exists($file_path)) {
                        unlink($file_path);
                    }
                    $postData['image'] = basename($imagePath);
                }
                $user->update($postData);
            }
            return success('User ' . $request->id == 0 ? 'added' : 'updated' . ' successfully.');
        } catch (Exception $e) {
            return error('Something went wrong!!!', $e->getMessage());
        }
    }

    /**
     * get edit user details
     */
    public function show($id)
    {
        try {
            $user = User::userRole()->where('id', $id)->select('id', 'name', 'first_name', 'last_name', 'email', 'created_at', 'image')->first();
            if (empty($user)) {
                return error('Invalid user details');
            }
            $user->url =  url('users');
            return success("Success", $user);
        } catch (\Exception $e) {
            return error('Something went wrong!', $e->getMessage());
        }
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        try {
            $user = User::userRole()->where('id', $id)->first();
            if (empty($user)) {
                return error('Invalid user details');
            }
            $image = $user->getAttributes()['image'] ?? null;
            $file_path =  storage_path(User::STORAGE_PATH . $image);
            $user->delete();
            if ($image != null && file_exists($file_path)) {
                unlink($file_path);
            }
            return success("User deleted successfully.");
        } catch (\Exception $e) {
            return error('Something went wrong!', $e->getMessage());
        }
    }
}
