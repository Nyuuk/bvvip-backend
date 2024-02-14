<?php

namespace App\Services;

use App\Models\Server;
use App\Models\UsersMarzban;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

class Marzban
{
    private static $marzban_url;
    private static $detailServer;

    public function __construct($id)
    {
        if (self::checkIdServers($id)) {
            self::changeMarzbanUrl($id);
            self::$detailServer = Server::find($id);
        } else {
            throw new Exception('Server not found');
        }
    }

    private static function changeMarzbanUrl($id)
    {
        $server = Server::find($id);
        if ($server->port != "443") {
            self::$marzban_url = "https://" . $server->ip . ':' . $server->port;
            return ;
        }
        self::$marzban_url = "https://" . $server->ip;
    }

    private static function checkIdServers($id)
    {
        $server = Server::find($id);
        if ($server) {
            return true;
        }
        return false;
    }

    private static function getBearerToken()
    {
        $response = Http::asForm()->post(self::$marzban_url . '/api/admin/token', [
            'username' => self::$detailServer->username,
            'password' => self::$detailServer->password,
            'grant_type' => "password"
        ]);
        if ($response->successful()) {
            self::$detailServer->token = $response->json()['access_token'];
            self::$detailServer->save();
        }
    }

    private static function checkToken()
    {
        if (self::$detailServer->token) {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . self::$detailServer->token])->get(self::$marzban_url . '/api/system');
            if ($response->successful()) {
                return true;
            } else {
                return false;
            }
            return false;
        }
        self::getBearerToken();
        return true;
    }

    public static function listAllUser()
    {
        if (!self::checkToken()) {
            self::getBearerToken();
        }
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . self::$detailServer->token])->get(self::$marzban_url . '/api/users');
        if ($response->successful()) {
            return $response->json();
        }
        throw new Exception($response->body());
    }

    public static function synchronize()
    {
        if (!self::checkToken()) {
            self::getBearerToken();
        }

        try {
            $data = self::listAllUser();

            foreach ($data['users'] as $item) {
                $username = $item['username'];
                $find = UsersMarzban::where("username",$username)->first();
                $expire = Carbon::createFromTimestamp($item['expire']);
                if ($find){
                    $find->expired_at = $expire;
                    $find->server_id = self::$detailServer->id;
                    $find->save();
                    continue;
                }
                $user = new UsersMarzban();
                $user->username = $username;
                $user->server_id = self::$detailServer->id;
                $user->expired_at = $expire;
                $user->save();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function test()
    {
        if (!self::checkToken()) {
            self::getBearerToken();
        }
        $response = self::listAllUser();
        return $response;
    }

}
