<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Models\UsersMarzban;
use App\Services\Marzban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserMarzbanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_server)
    {
        //
        $data = UsersMarzban::all();
        return ResponseHelpers::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $validator = Validator::make($request->all(), [
        //     'username' => ['required', 'unique:users_marzbans,username'],
        //     'number' => ['required', 'numeric'],
        //     'expired_at' => ['required', 'date'],
        // ]);

        // if ($validator->fails()) {
        //     return ResponseHelpers::validation($validator->errors());
        // }

        // $data = UsersMarzban::create($request->only(['username', 'number', 'expired_at']));
        // return ResponseHelpers::success($data);
        return ResponseHelpers::error('Sorry, this route has been taken by the nyuuk.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = UsersMarzban::find($id);
        if ($data) {
            return ResponseHelpers::success($data);
        }

        return ResponseHelpers::notFound();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_user)
    {
        //
        $validator = Validator::make($request->all(), [
            'username' => ['unique:users_marzbans,username,' . $id_user],
            'number' => ['numeric'],
            'expired_at' => ['date'],
        ]);

        if ($validator->fails()) {
            return ResponseHelpers::validation($validator->errors());
        }

        $data = UsersMarzban::find($id_user);
        if ($data) {
            $data->update($request->only(['username', 'number', 'expired_at']));
            return ResponseHelpers::success($data);
        }

        return ResponseHelpers::notFound();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_user)
    {
        //
        $data = UsersMarzban::find($id_user);
        if ($data) {
            $data->delete();
            return ResponseHelpers::success($data);
        }

        return ResponseHelpers::notFound();
    }
}
