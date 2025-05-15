<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use FileUpload;

    public function index()
    {
        $users = User::all();
        return response()->json([
            'users' => $users
        ]);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg|max:2048',
        ]);
        //get auth user id
        $user_auth = Auth::user();
        $user = User::find($user_auth->id);
        if ($request->hasFile('image')) {
            $user->image = $this->uploadFile($request->file('image'));
        }
        $user->save();
        return response()->json([
            'message' => 'File uploaded successfully',
        ]);
    }
}
