<?php

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\api\ServersController;
use App\Http\Controllers\api\UserMarzbanController;
use App\Services\Marzban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::resource('servers', ServersController::class);
// Route::resource('user-marzban', UserMarzbanController::class);
Route::prefix('users-marzban')->controller(UserMarzbanController::class)->group(function () {
    Route::get('/{id_server}', 'index');
    Route::post('/', 'store');
    Route::get('/{id_user}/detail', 'show');
    Route::put('/{id_user}', 'update');
    Route::delete('/{id_user}', 'destroy');
});

Route::get('/users/sync', function () {
    $servers = App\Models\Server::all();
    $total = $servers->map(function ($server) {
        $marzban = new Marzban($server->id);
        return [ 'server' => $server->name, 'total' => $marzban->synchronize(), 'count' => $server->usersMarzban()->count() ];
    });

    return ResponseHelpers::success($total);
});


Route::get('/test', function () {
    $marzban = new Marzban(1);
    return response()->json($marzban->test());
});
