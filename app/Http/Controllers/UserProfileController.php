<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\ValidCurrentUserPassword;
use App\Http\Resources\Detail\UserResource;
use App\Http\Requests\UpdateUserProfileRequest;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserProfileController extends Controller
{
    /**
     * View profile
     *
     * @param Request $request
     * @return UserResource
     */
    public function show(Request $request)
    {
        $user = auth('api')->user();
        return new UserResource($user);
    }

    /**
     * Update profile
     *
     * @param UpdateUserProfileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserProfileRequest $request)
    {
        $user = auth('api')->user();
        $input = $request->only('name', 'email', 'username', 'avatar');
        $user->update($input);

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'User profile information updated successfully'
            ]
        ]);
    }

    /**
     * Change password
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
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
            'data' => [
                'error' => false,
                'message'   => 'Password changed successfully!'
            ]
        ]);
    }
}
