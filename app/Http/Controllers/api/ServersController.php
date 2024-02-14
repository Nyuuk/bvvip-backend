<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Server::all();
        return ResponseHelpers::send($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'user_email' => ['bail', 'required', 'email'],
            'name' => ['bail', 'required', 'string', 'unique:servers,name'],
            'ip' => ['bail', 'required', 'string'],
            'port' => ['bail', 'required', 'string'],
            'username' => ['bail', 'required', 'string'],
            'password' => ['bail', 'required', 'string'],
        ], [], [
            'user_email' => 'User Email',
            'name' => 'Server Name',
            'ip' => 'Server IP',
            'port' => 'Server Port',
            'username' => 'Server Username',
            'password' => 'Server Password',
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return ResponseHelpers::validation($validator->errors());
        }

        $serverData = [
            'ip' => $request->ip,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'name' => $request->name,
        ];
        $data = Server::create($serverData);
        return ResponseHelpers::send($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Server::find($id);
        return ResponseHelpers::send($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'user_email' => ['bail', 'email'],
            'name' => ['bail', 'string', 'unique:servers,name'],
            'ip' => ['bail', 'string'],
            'port' => ['bail', 'string'],
            'username' => ['bail', 'string'],
            'password' => ['bail', 'string'],
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return ResponseHelpers::validation($validator->errors());
        }

        $data = Server::find($id);
        $data->update($request->all());
        return ResponseHelpers::send($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $data = Server::find($id);
        $data->delete();
        return ResponseHelpers::send($data);
    }
}
