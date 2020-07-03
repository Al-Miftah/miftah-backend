<?php

namespace App\Http\Controllers;

use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\Rules\ValidCurrentUserPassword;
use App\Http\Requests\UpdateUserProfileRequest;

class UserProfileController extends Controller
{
    use UploadTrait;

    public function show(Request $request)
    {
        $user = auth('api')->user();

        return new UserResource($user);
    }

    public function update(UpdateUserProfileRequest $request)
    {
        $user = auth('api')->user();
        $input = $request->only('name', 'email', 'username');
        $user->update($input);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $folder = 'public/uploads/profile';
            if (app()->environment(['staging', 'production'])) {
                $folder = 'uploads/profile';
            }
            $path = $this->upload($avatar, $folder);
            $user->avatar = $path;
            $user->save();
        }

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'User profile information updated successfully'
            ]
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new ValidCurrentUserPassword],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message'   => 'Password changed successfully!'
        ]);
    }
}
