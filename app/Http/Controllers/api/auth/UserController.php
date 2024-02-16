<?php

namespace App\Http\Controllers\api\auth;

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
            'min' => 'The :attribute must be at least :min characters.',
            'same' => 'The :attribute and :other must match.',
            'exists' => 'The selected :attribute is invalid.',
        ];

        $attributes = [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'role' => 'Role',
        ];

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'same:password'],
            'role' => ['required', 'string', 'exists:roles'],
        ], $messages, $attributes);

        if ($validator->fails()) {
            return ResponseHelpers::validation($validator->messages(), $attributes);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return ResponseHelpers::success($user, 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return ResponseHelpers::error(null, 'User not found', 404);
        }

        return ResponseHelpers::success($user, 'User retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return ResponseHelpers::error(null, 'User not found', 404);
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
            'min' => 'The :attribute must be at least :min characters.',
            'same' => 'The :attribute and :other must match.',
            'exists' => 'The selected :attribute is invalid.',
        ];

        $attributes = [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'role' => 'Role',
        ];

        $validator = Validator::make($request->all(), [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255'],
            'password_old' => ['string', 'min:8'],
            'password_new' => ['string', 'min:8'],
            'confirm_password_new' => ['string', 'same:password_new'],
            'role' => ['string', 'exists:roles'],
        ], $messages, $attributes);

        if ($validator->fails()) {
            return ResponseHelpers::validation($validator->messages(), $attributes);
        }
        $data = [];

        foreach ($request->all() as $key => $value) {
            if ($key != 'password_old' && $key != 'password_new' && $key != 'confirm_password_new') {
                $data[$key] = $value;
            }
        }


        if (isset($request->password_old) && isset($request->password_new) && isset($request->confirm_password_new)) {
            if (Hash::check($request->password_old, $user->password)) {
                $data['password'] = Hash::make($request->password_new);
            } else {
                return ResponseHelpers::error(null, 'Old password is incorrect', 422);
            }
        }

        $user->update($data);
        $user->save();

        return ResponseHelpers::success($user, 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return ResponseHelpers::error(null, 'User not found', 404);
        }

        $user->delete();
        return ResponseHelpers::success(null, 'User deleted successfully');
    }
}
